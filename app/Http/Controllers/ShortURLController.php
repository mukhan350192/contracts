<?php

namespace App\Http\Controllers;

use App\Models\ShortURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShortURLController extends Controller
{
    public function sign($token){
        $data =  ShortURL::getDocs($token);
        $new = [
            'id' => $data['id'],
            'document_id' => $data['document_id'],
            'name' => $data['name'],
            'document' => 'https://api.mircreditov.kz/uploads/'.$data['document'],
            'iin' => $data['iin'],
            'phone' => $data['phone']
        ];
        return view('sign')->with($new);
    }

    public function restore($token){
        $data = DB::table('restore_url')->where('token',$token)->where('status',false)->first();

        if (!$data){
            $return = ['code' => 404];
            return view('restore')->with($return);
        }
        $return = [
            'restoreID' => $data->id,
            'userID' => $data->user_id,
            'code' => 200,
        ];
        return view('restore')->with($return);
    }
}
