<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model {
    protected $primaryKey = 'SeasonID';
    protected $guarded = [];

    public function series() {
        return $this->belongsTo(Series::class, 'SeriesID');
    }

    public function episodes() {
        return $this->hasMany(Episode::class,'SeasonID');
    }
}
