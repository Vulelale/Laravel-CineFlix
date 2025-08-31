<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Series;


class PurchaseController extends Controller
{
    public function store(Film $film)
    {
        
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Morate se prijaviti da biste kupili film!');   
        }
        // Provera da li korisnik već poseduje film
        if (Purchase::where('UserID', Auth::id())
        ->where('FilmID', $film->FilmID)
        ->exists()) {
            return back()->withErrors(['error' => 'Već posedujete ovaj film']);
        }
        
        // Provera da li film zahteva pretplatu
        if ($film->IsSubscriptionRequired) {
            
            $activeSubscription = Subscription::where('UserID', Auth::id())
            ->where('Status', 'Active')
            ->where('EndDate', '>', now())
            ->first();
            
            if (!$activeSubscription) {
                return redirect()->route('subscription.sub')->withErrors([
                    'error' => 'Morate imati aktivnu pretplatu da biste kupili ovaj film!'
                ]);
            }
        }
        
        DB::transaction(function () use ($film) {
            // Kreiranje kupovine
            Purchase::create([
                'UserID' => Auth::id(),
                'FilmID' => $film->FilmID,
                'Amount' => $film->Price,
                'PurchaseDate' => now()->setTimezone(config('app.timezone'))
            ]);
            
        });
        
        return redirect()->route('movies.show', $film->FilmID)
        ->with('success', 'Uspešno ste kupili film!');
    }
    
    public function purchaseSeries(Series $series)
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'Morate se prijaviti da biste kupili seriju!');   
        }
        
        // Provera da li korisnik već poseduje seriju
        if (Purchase::where('UserID', Auth::id())
        ->where('SeriesID', $series->SeriesID)
        ->exists()) {
            return back()->withErrors(['error' => 'Već posedujete ovu seriju']);
        }
        
        // Provera da li serija zahteva pretplatu
        if ($series->is_subscription_required) {
            $activeSubscription = Subscription::where('UserID', Auth::id())
            ->where('Status', 'Active')
            ->where('EndDate', '>', now())
            ->first();
            
            if (!$activeSubscription) {
                return redirect()->route('subscription.sub')->withErrors([
                    'error' => 'Morate imati aktivnu pretplatu da biste kupili ovu seriju!'
                ]);
            }
        }
        
        // Kreiranje kupovine
        Purchase::create([
            'UserID' => Auth::id(),
            'SeriesID' => $series->SeriesID,
            'Amount' => $series->price,
            'PurchaseDate' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Serija uspešno kupljena!');
    }
    
    
}
