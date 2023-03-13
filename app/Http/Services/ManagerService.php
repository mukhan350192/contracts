<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ManagerService
{
    public function approve(int $documentID)
    {
        DB::table('documents')->where('id', $documentID)->update(['status' => 1]);
        return response()->success();
    }

    public function create(string $phone, string $password, string $iin, string $name)
    {
        $s = User::query()->insertGetId([
            'name' => $name,
            'phone' => $phone,
            'password' => bcrypt($password),
            'user_type' => 3,
            'iin' => $iin,
        ]);
        return response()->success();
    }

    public function getAll()
    {
        $docs = DB::table('documents')->where('status', 0)->get()->toArray();
        $data['docs'] = $docs;
        return response()->success($data);
    }
}
