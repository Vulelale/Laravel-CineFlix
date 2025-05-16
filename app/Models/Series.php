<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
