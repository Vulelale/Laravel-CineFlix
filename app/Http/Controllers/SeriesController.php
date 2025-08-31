<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 

class SeriesController extends Controller
{
    public function create()
    {
        if (!Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403, 'Nemate pravo pristupa!');
        }
        
        return view('series.create');
    }
    
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'release_date' => 'required|date',
            'price' => 'required|numeric',
            'genre' => 'nullable|string',
            'description' => 'nullable|string',
            'seasons' => 'required|array|min:1',
            'seasons.*.episodes' => 'required|array|min:1',
            'seasons.*.episodes.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        
        try {
            // Kreiranje serije
            $series = Series::create([
                'title' => $request->title,
                'image_path' => $request->file('image')->store('series', 'public'),
                'release_date' => $request->release_date,
                'price' => $request->price,
                'is_subscription_required' => $request->has('is_subscription_required'),
                'genre' => $request->genre,
                'description' => $request->description
            ]);
            
            // Dodaje sezone i epizode
            foreach ($request->seasons as $seasonData) {
                $season = $series->seasons()->create([
                    'season_number' => $seasonData['season_number'],
                    'title' => $seasonData['title'] ?? "Season {$seasonData['season_number']}",
                    'release_year' => $seasonData['release_year']
                ]);
                
                foreach ($seasonData['episodes'] as $episodeData) {
                    
                    $imagePath = null;
                    if (isset($episodeData['image'])) {
                        $image = $episodeData['image'];
                        if ($image->isValid()) {
                            $imagePath = $image->store('episodes', 'public');
                        }
                    }
                    $season->episodes()->create([
                        'episode_number' => $episodeData['episode_number'],
                        'title' => $episodeData['title'],
                        'duration' => $episodeData['duration'],
                        'air_date' => $episodeData['air_date'],
                        'image_path' => $imagePath
                    ]);
                }
            }
            
            return redirect()->route('admin.dashboard')->with('success', 'Serija је dodata!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Грешка: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function index()
    {
        $series = Series::withCount('seasons')->paginate(12); 
        return view('tvshows', compact('series')); 
    }
    
    public function show(Series $series)
    {
        $series->load(['seasons.episodes' => function($query) {
            $query->orderBy('episode_number');
        }]);
        
        return view('series.show', compact('series'));
    }
    
    public function edit(Series $series)
    {
        if (!Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        
        $series->load(['seasons.episodes' => function($query) {
            $query->select('EpisodeID', 'SeasonID', 'episode_number', 'title', 'duration', 'air_date', 'image_path');
        }]);
        return view('series.edit', compact('series'));
    }
    
    public function destroy(Series $series)
    {
        if (!Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        
        if ($series->image_path) {
            Storage::disk('public')->delete($series->image_path);
        }
        
        $series->delete();
        return back()->with('success', 'Serija je obrisana!');
    }
    
    public function update(Request $request, Series $series)
    {
        if (!Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
            'genre' => 'nullable|string',
            'release_date' => 'required|date',
            'price' => 'required|numeric',
            'seasons' => 'required|array|min:1',
            'seasons.*.episodes' => 'required|array|min:1',
            'seasons.*.episodes.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        
        try {
            DB::beginTransaction();
            
           
            $series->update([
                'title' => $request->title,
                'description' => $request->description,
                'genre' => $request->genre,
                'release_date' => $request->release_date,
                'price' => $request->price,
                'is_subscription_required' => $request->has('is_subscription_required'),
            ]);
            
           
            if ($request->hasFile('image')) {
                if ($series->image_path) {
                    Storage::disk('public')->delete($series->image_path);
                }
                $series->image_path = $request->file('image')->store('series', 'public');
                $series->save();
            }
            
            
            $existingSeasons = $series->seasons->pluck('SeasonID')->toArray();
            $processedSeasons = [];
            
            foreach ($request->seasons as $seasonData) {
                
                $season = $series->seasons()->updateOrCreate(
                    ['SeasonID' => $seasonData['id'] ?? null],
                    [
                        'season_number' => $seasonData['season_number'],
                        'title' => $seasonData['title'],
                        'release_year' => $seasonData['release_year']
                        ]
                    );
                    
                    $processedSeasons[] = $season->SeasonID;
                    
                    
                    $existingEpisodes = $season->episodes->pluck('EpisodeID')->toArray();
                    $processedEpisodes = [];
                    
                    foreach ($seasonData['episodes'] as $episodeData) {
                     
                        $episode = $season->episodes()->updateOrCreate(
                            ['EpisodeID' => $episodeData['id'] ?? null],
                            [
                                'episode_number' => $episodeData['episode_number'],
                                'title' => $episodeData['title'],
                                'duration' => $episodeData['duration'],
                                'air_date' => $episodeData['air_date']
                                ]
                            );
                            
                            
                            if (isset($episodeData['image'])) {
                                $this->handleEpisodeImage(
                                    $episodeData['image'],
                                    $episode
                                );
                            }
                            
                            $processedEpisodes[] = $episode->EpisodeID;
                        }
                        
                       
                        $episodesToDelete = $season->episodes()
                        ->whereNotIn('EpisodeID', $processedEpisodes)
                        ->get();
                        
                        foreach ($episodesToDelete as $episodeToDelete) {
                            if ($episodeToDelete->image_path) {
                                Storage::disk('public')->delete($episodeToDelete->image_path);
                            }
                            $episodeToDelete->delete();
                        }
                    }
                    
                    
                    $seasonsToDelete = $series->seasons()
                    ->whereNotIn('SeasonID', $processedSeasons)
                    ->get();
                    
                    foreach ($seasonsToDelete as $seasonToDelete) {
                        
                        foreach ($seasonToDelete->episodes as $episode) {
                            if ($episode->image_path) {
                                Storage::disk('public')->delete($episode->image_path);
                            }
                        }
                        $seasonToDelete->delete();
                    }
                    
                    DB::commit();
                    return redirect()->route('admin.dashboard')->with('success', 'Serija je ažurirana!');
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    return back()->withErrors(['error' => 'Greska: ' . $e->getMessage()]);
                }
            }
            
            
            private function handleEpisodeImage($image, Episode $episode)
            {
                if ($image instanceof \Illuminate\Http\UploadedFile && $image->isValid()) {
                   
                    if ($episode->image_path) {
                        Storage::disk('public')->delete($episode->image_path);
                    }
                    
                    
                    $episode->image_path = $image->store('episodes', 'public');
                    $episode->save();
                }
            }
        }
        