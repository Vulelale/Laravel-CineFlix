<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    protected $table = 'Marketing';
    protected $primaryKey = 'MarketingID';
    public $timestamps = false;

    protected $fillable = ['FilmID', 'Budget', 'Strategy'];

    public function film()
    {
        return $this->belongsTo(Film::class, 'FilmID');
    }
}
