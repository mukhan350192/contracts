<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortURL extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'token',
        'status',
        'user_id',
        'phone',
        'iin'
    ];

    public static function getDocs($token)
    {
        return self::query()->join('documents', 'document_id', '=', 'documents.id')
            ->where('short_u_r_l_s.token', $token)
            ->where('short_u_r_l_s.status', 0)
            ->select('short_u_r_l_s.id','document_id','iin','phone','name')
            ->first();
    }

    public function sendingDocs(){
        return $this->hasOne(Document::class,'id','document_id')->latest();
    }

    public function signHistory(){
        return $this->hasOne(VerigramSignHistory::class,'shortID','id')->latest();
    }
}
