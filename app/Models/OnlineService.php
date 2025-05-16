<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineService extends Model
{
    protected $table = 'OnlineService';
    protected $primaryKey = 'ServiceID';
    public $timestamps = false;

    protected $fillable = ['FilmID', 'ViewCount', 'Rating'];

    public function film()
    {
        return $this->belongsTo(Film::class, 'FilmID');
    }
}
