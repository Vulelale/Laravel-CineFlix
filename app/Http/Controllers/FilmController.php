<?php



namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Series;

class FilmController extends Controller
{
    // Prikaz svih filmova 
    public function index()
    {
        $films = Film::all();
        return view('movies', compact('films'));
    }
    
    // Forma za kreiranje filma (za admina)
    public function create()
    {
        // Provera da li je korisnik admin 
        if (! Auth::check() || Auth::user()->Role !=='Administrator') {
            abort(403, 'Nemate pravo pristupa!');
        }
        
        return view('films.create');
    }
    
    // Čuvanje filma u bazi
    public function store(Request $request)
    {
        if (! Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        try {
            $attributes = $request->validate([
                'Title' => ['required', 'string', 'max:100'],
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
                'ReleaseDate' => ['nullable', 'date'],
                'Duration' => ['nullable', 'integer'],
                'Price' => ['required', 'numeric'],
                'IsSubscriptionRequired' => ['sometimes', 'accepted'],
                'Genre' => ['nullable', 'string', 'max:50'],         
                'Description' => ['nullable', 'string', 'max:2000'], 
            ]);
            $attributes['IsSubscriptionRequired'] = $request->has('IsSubscriptionRequired');
            $attributes['image_path'] = $request->file('image')->store('films', 'public');
            
            Film::create($attributes);
            
            return redirect()->route('admin.dashboard')->with('success', 'Film je dodat!');
            
        } catch (\Exception $e) {
            return back()
            ->withErrors(['error' => 'Došlo je do greške: ' . $e->getMessage()])
            ->withInput();
        }
    }
    
    public function show(Film $film)
    {
        return view('movies.show', compact('film'));
    }
    
    //Na home page-u izbacuje najnovije filmove i serije kao i slider
    public function home()
    {
        $sliderFilms = Film::orderBy('ReleaseDate', 'desc')->take(3)->get();
        $recommendedFilms = Film::orderBy('Price', 'desc')->take(4)->get();
        $recommendedSeries = Series::orderBy('release_date', 'desc')->take(3)->get();
        
        return view('home', compact('sliderFilms', 'recommendedFilms','recommendedSeries'));
    }
    
    
    //dashboard edit
    public function edit(Film $film)
    {
        if (! Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        return view('admin.films.edit', compact('film'));
    }
    
    public function update(Request $request, Film $film)
    {
        if (! Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        $attributes = $request->validate([
            'Title' => ['required', 'string', 'max:100'],
            'ReleaseDate' => ['required', 'date'],
            'Duration' => ['nullable', 'integer'],  
            'Price' => ['required', 'numeric'],
            'IsSubscriptionRequired' => ['sometimes', 'accepted'],
            'Genre' => ['nullable', 'string', 'max:50'],          
            'Description' => ['nullable', 'string', 'max:2000'], 
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048']
        ]);
        $attributes['IsSubscriptionRequired'] = $request->has('IsSubscriptionRequired');
        
        // Ažuriraj sliku ako je uploadovana nova
        if ($request->hasFile('image')) {
            // Obriši staru sliku
            if ($film->image_path) {
                Storage::disk('public')->delete($film->image_path);
            }
            
            // Sačuvaj novu sliku
            $imagePath = $request->file('image')->store('films', 'public');
            $attributes['image_path'] = $imagePath;
        }
        
        $film->update($attributes);
        
        return redirect()->route('admin.dashboard')->with('success', 'Film je ažuriran!');
    }
    
    public function destroy(Film $film)
    {
        if (! Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }
        
        $film->delete();
        
        return back()->with('success', 'Film je obrisan!');
    }
    
    public function search(Request $request)
    {
        $query = $request->input('search');
        
        //Pretraga filmova
        $films = Film::when($query, function($q) use ($query) {
                return $q->where('Title', 'LIKE', "%{$query}%");
            })
            ->orderBy('ReleaseDate', 'desc')
            ->paginate(10);
        
        // Pretraga serija
        $series = Series::when($query, function($q) use ($query) {
                return $q->where('title', 'LIKE', "%{$query}%");
            })
            ->orderBy('release_date', 'desc')
            ->paginate(10);
    
        return view('movies.search-results', compact('films', 'series', 'query'));
    }
    
}
