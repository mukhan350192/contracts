<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    use HasFactory;

    public function status(){
        return $this->hasOne(DocumentStatusHistory::class,'doc_id','id')->latest();
    }

    public function approvedStatus(){
        return $this->hasOne(DocumentStatusHistory::class,'doc_id','id')->latest();
    }

}
