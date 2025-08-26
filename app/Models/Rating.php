<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $primaryKey = 'RatingID';

    protected $fillable = [
        'UserID', 'FilmID', 'SeriesID', 'rating'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function film() {
        return $this->belongsTo(Film::class, 'FilmID');
    }

    public function series() {
        return $this->belongsTo(Series::class, 'SeriesID');
    }
}   
