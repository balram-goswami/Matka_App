<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'transaction_type',
        'utr_number',
        'diposit_image',
        'deposit_amount',
        'withdraw_amount',
        'remark',
        'request_status'
    ];
}
