<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'Subscriptions';
    protected $primaryKey = 'SubscriptionID';
    public $timestamps = false;

    protected $fillable = [
        'UserID', 'StartDate', 'EndDate', 'Status', 'Price'
    ];

    // Veza ka User-u
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
