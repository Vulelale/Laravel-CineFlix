<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'Users';
    protected $primaryKey = 'UserID';
    public $timestamps = false;
    
    protected $fillable = [
        'FirstName', 'LastName', 'Email', 'password', 'Role'
    ];
    
    protected $hidden = ['password'];
    
    protected function casts(): array
    {
        return [
            'password'=>'hashed'
        ];
    }
    
    
    public function hasActiveSubscription()
    {
        return $this->subscriptions()
        ->where('Status', 'Active')
        ->where('EndDate', '>', now())
        ->exists();
    }
    
   
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'UserID');
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'UserID');
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'UserID');
    }
}

