<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Film; 
use App\Models\Series;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (! Auth::check() || Auth::user()->Role !== 'Administrator') {
            abort(403);
        }

        $users = User::with(['purchases.film','subscriptions'])
            ->orderBy('UserID', 'desc')
            ->paginate(10);
            

            $films = Film::orderBy('ReleaseDate', 'desc')->paginate(10);
            $series = Series::withCount('seasons')->paginate(10);

        return view('admin.dashboard', compact('users','films','series'));
    }
}
