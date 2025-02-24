<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes; // Add SoftDeletes trait

    protected $primaryKey = 'user_id';

    const ADMIN = 'admin';
    const USER = 'user';
    const SUBADMIN = 'subadmin';
    const PLAYER = 'player';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'phone',
        'photo',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deleted_at' => 'datetime', // Ensure deleted_at is treated as a date
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function walletDetails()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'user_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'user_id');
    }

    public function players()
    {
        return $this->hasMany(User::class, 'parent', 'user_id');
    }

    public function activePlayers()
    {
        return $this->hasMany(User::class, 'parent', 'user_id')->where('status', 'Active');
    }

    public function blockPlayers()
    {
        return $this->hasMany(User::class, 'parent', 'user_id')->where('status', 'Block');
    }
}
