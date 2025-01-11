<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'answer',
        'bid_amount',
        'status',
        'bid_result',
        'winning_amount',
    ];
}
