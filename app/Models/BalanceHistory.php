<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceHistory extends Model
{
    use HasFactory;
    protected $table='balance_history';
    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'balance_before',
        'balance_after',
        'description',
    ];
}
