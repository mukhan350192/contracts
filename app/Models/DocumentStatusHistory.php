<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentStatusHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'status_id',
        'doc_id',
        'comment'
    ];
}
