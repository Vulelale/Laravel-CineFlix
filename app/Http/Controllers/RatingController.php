<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function storeFilm(Request $request, $filmId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Provera da li je korisnik kupio film
        $hasPurchased = Purchase::where('UserID', Auth::id())
            ->where('FilmID', $filmId)
            ->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['error' => 'Morate kupiti film da biste ga ocenili!']);
        }

        Rating::updateOrCreate(
            ['UserID' => Auth::id(), 'FilmID' => $filmId],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Uspešno ste ocenili film!');
    }

    public function storeSeries(Request $request, $seriesId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $hasPurchased = Purchase::where('UserID', Auth::id())
            ->where('SeriesID', $seriesId)
            ->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['error' => 'Morate kupiti seriju da biste je ocenili!']);
        }

        Rating::updateOrCreate(
            ['UserID' => Auth::id(), 'SeriesID' => $seriesId],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'Uspešno ste ocenili seriju!');
    }
}

