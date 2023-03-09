<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class ManagerService
{
    public function approve(int $documentID)
    {
        DB::table('documents')->where('id', $documentID)->update(['status' => 1]);
        return response()->success();
    }
}
