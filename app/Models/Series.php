<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Series extends Model {
    
    protected $table = 'series'; 
    protected $primaryKey = 'SeriesID'; 
    protected $guarded = [];
    
    public function seasons() {
        return $this->hasMany(Season::class,'SeriesID');
    }
    
    public function episodes() {
        return $this->hasManyThrough(Episode::class, Season::class);
    }
    
    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class, 'SeriesID');
    }
    
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    
    public function ratingsCount()
    {
        return $this->ratings()->count();
    }
    
}
