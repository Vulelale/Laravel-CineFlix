<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\RatingController;

/* Route::get('/', function () {
    return view('/home');
});

Route::get('/movies', function () {
    return view('movies');
}); */

Route::get('/tvshows', function () {
    return view('tvshows');
});

// Auth
Route::get('/register',[RegisteUserController::class,'create']);
Route::post('/register',[RegisteUserController::class,'store']);

Route::get('/login',[LoginController::class,'create']);
Route::post('/login',[LoginController::class,'store']);

Route::post('/logout',[LoginController::class,'destroy']);


//prikaz svih filmova u movies page-u
Route::get('/movies', [FilmController::class, 'index'])->name('movies.index');

//vraca pogled za kreiranje novog filma i posle gadja funkciju za pravljenje istog
Route::middleware('auth')->group(function () {
    Route::get('/films/create', [FilmController::class, 'create'])->name('films.create');
    Route::post('/films', [FilmController::class, 'store'])->name('films.store');
});
//prikaz kada se klikne na neki film
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');

//pretraga filmova
Route::get('/search', [FilmController::class, 'search'])->name('movies.search');

//Na home page-u izbacuje najnovije filmove i updajtuje slider
Route::get('/', [FilmController::class, 'home'])->name('home');
 
// Kupovina filma
Route::post('/purchase/{film}', [PurchaseController::class, 'store'])
     ->name('purchase.store');
// Ako nemas aktivnu pretplatu prebacuje te na view da je aktiviras
Route::middleware(['auth'])->group(function () {
    Route::get('/subscription', [SubscriptionController::class, 'create'])->name('subscription.sub');
    Route::post('/subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');
Route::delete('/subscription/{subscription}', [SubscriptionController::class, 'destroy'])
->name('subscription.cancel');
});
        

 // Admin dashboard
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/films/{film}', [FilmController::class, 'destroy'])->name('films.destroy');
    Route::get('/admin/films/{film}/edit', [FilmController::class, 'edit'])->name('films.edit');
    Route::put('/admin/films/{film}', [FilmController::class, 'update'])->name('films.update');
});

// User dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::delete('/user/purchases/{purchase}', [UserController::class, 'cancelPurchase'])->name('purchases.cancel');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/user/subscription/{subscription}', [UserController::class, 'destroy'])
->name('subscription.cancel');
});

// Serije
Route::middleware(['auth'])->group(function () {
    Route::get('/series/create', [SeriesController::class, 'create'])->name('series.create');
    Route::post('/series', [SeriesController::class, 'store'])->name('series.store');
    Route::get('/series/{series}/edit', [SeriesController::class, 'edit'])->name('series.edit');
    Route::put('/series/{series}', [SeriesController::class, 'update'])->name('series.update');
    Route::delete('/series/{series}', [SeriesController::class, 'destroy'])->name('series.destroy');
});

Route::get('/tvshows', [SeriesController::class, 'index'])->name('tvshows.index');
Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');


Route::post('/purchase/series/{series}', [PurchaseController::class, 'purchaseSeries'])
    ->name('purchase.series');

    Route::post('/movies/{film}/rate', [RatingController::class, 'storeFilm'])->name('movies.rate');
Route::post('/series/{series}/rate', [RatingController::class, 'storeSeries'])->name('series.rate');



    

