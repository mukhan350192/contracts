<?php

namespace App\Http\Services;

use App\Models\ShortURL;
use App\Models\User;
use Illuminate\Support\Str;

class ClientService
{
    public function create(string $iin, string $password, string $phone, int $id)
    {
        $user = User::create([
            'iin' => $iin,
            'password' => bcrypt($password),
            'phone' => $phone,
            'user_type' => 2,
            'name' => Str::random(8),
        ]);

        $token = $user->createToken('api', ['client'])->plainTextToken;
        ShortURL::query()->find($id)->update(['status' => 1]);
        return response()->success(['token' => $token, 'user_type' => 2]);
    }

    public function clientDocs(int $userID)
    {
        $user = User::query()->find($userID);
        $docs = ShortURL::query()->join('documents','document_id','documents.id')
            ->select('documents.name','documents.document','short_u_r_l_s.status')
            ->where('iin',$user->iin)
            ->get();
        $data['doc'] = $docs;
        return response()->success($data);
    }
}
