<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class LawyerService
{
    public function getDocs()
    {
        $all = DB::table('documents')->where('status', 0)->get();
        $data = [];
        if (!$all) {
            return response()->success();
        }
        foreach ($all as $a) {
            $data[] = [
                'link' => $a->document,
                'name' => $a->name,
                'created_at' => $a->created_at,
            ];
        }
        return response()->success($data);
    }
}
