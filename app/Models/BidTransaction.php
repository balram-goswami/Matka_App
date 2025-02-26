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
        'slot',
        'harf_digit',
        'bid_result',
        'bid_amount',
        'win_amount',
        'subadmin_amount',
        'player_commission',
        'winamount_from_admin',
        'admin_amount',
        'subadmin_commission',
        'admin_dif',
        'subadmin_dif',
        'result_status',
        'status'
    ];
}
