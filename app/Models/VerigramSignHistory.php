<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerigramSignHistory extends Model
{
    use HasFactory;

    protected $fillable = [
      'firstName',
      'gender',
      'iin',
      'lastName',
      'middleName',
      'originalImage',
      'facePicture',
      'shortID',
      'phone'
    ];

    public static function make($firstName,$gender,$iin,$lastName,$middleName,$originalImage,$facePicture,$shortID,$phone,$best_frame){
        return self::query()->create([
            'firstName' => $firstName,
            'gender' => $gender,
            'iin' => $iin,
            'lastName' => $lastName,
            'middleName' => $middleName,
            'originalImage' => $originalImage,
            'facePicture' => $facePicture,
            'shortID' => $shortID,
            'phone' => $phone,
            'best_frame' => $best_frame
        ]);
    }
}
