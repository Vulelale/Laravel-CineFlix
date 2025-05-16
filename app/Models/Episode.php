<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model {
    protected $primaryKey = 'EpisodeID';
    protected $guarded = [];

    public function season() {
        return $this->belongsTo(Season::class,'SeasonID');
    }
}
