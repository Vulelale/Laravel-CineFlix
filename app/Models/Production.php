<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $table = 'Production';
    protected $primaryKey = 'ProductionID';
    public $timestamps = false;

    protected $fillable = ['Name', 'Budget', 'Status'];

    public function films()
    {
        return $this->hasMany(Film::class, 'ProductionID');
    }
}
