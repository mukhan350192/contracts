<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;

    protected $table = 'sms_history';
    protected $fillable = [
        'user_id',
        'phone',
        'status'
    ];

    public static function make(int $userID,string $phone){
        return Sms::query()->insertGetId([
           'user_id' => $userID,
           'phone' => $phone,
        ]);
    }
}
