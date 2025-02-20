<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tofrom_id',
        'credit',
        'debit',
        'balance',
        'remark'
    ];
}
