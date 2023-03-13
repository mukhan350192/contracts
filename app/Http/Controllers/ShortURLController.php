<?php

namespace App\Http\Controllers;

use App\Models\ShortURL;
use Illuminate\Http\Request;

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
}
