<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'Films';
    protected $primaryKey = 'FilmID';
    public $timestamps = false;

    protected $fillable = [
        'Title', 'ProductionID', 'ReleaseDate', 'Duration', 'Price', 'IsSubscriptionRequired','image_path','Genre','Description'
    ];

    

    
    public function production()
    {
        return $this->belongsTo(Production::class, 'ProductionID');
    }

   
    public function marketing()
    {
        return $this->hasMany(Marketing::class, 'FilmID');
    }

    public function onlineService()
    {
        return $this->hasOne(OnlineService::class, 'FilmID');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'FilmID');
    }
}
