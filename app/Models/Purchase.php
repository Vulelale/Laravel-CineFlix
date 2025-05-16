<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'Purchases';
    protected $primaryKey = 'PurchaseID';
    public $timestamps = false; 
    
    protected $fillable = ['UserID', 'FilmID', 'Amount','PurchaseDate','SeriesID'];
    
    public function getPurchaseDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
    
    public function film()
    {
        return $this->belongsTo(Film::class, 'FilmID');
    }
    
    public function series()
    {
        return $this->belongsTo(Series::class,'SeriesID');
    }
}
