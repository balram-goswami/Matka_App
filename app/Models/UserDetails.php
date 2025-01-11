<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetails extends Model
{
    use HasFactory;
    protected $table = 'users_details';

    protected $fillable = [
        'user_id', 
        'dob', 
        'address', 
        'education',
        'languages',
        'experience',
        'expertise',
        'about',
        'price',
        'service',
        'rating',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
