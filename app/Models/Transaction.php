<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'Transactions';
    protected $primaryKey = 'TransactionID';
    public $timestamps = true; 

    protected $fillable = ['UserID', 'Amount'];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
