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
        'parent_id',
        'answer',
        'bid_amount',
        'win_amount',
        'subadmin_share',
        'admin_share',
        'subadmin_cut',
        'admin_cut',
        'subadminGet',
        'status',
        'bid_result',
        'winning_amount',
        'harf_digit'
    ];
}
