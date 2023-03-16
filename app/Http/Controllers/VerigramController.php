<?php

namespace App\Http\Controllers;

use App\Http\Services\VerigramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerigramController extends Controller
{
    public function getAccessToken(VerigramService $service){
        return $service->getToken();
    }

    public function fields(Request $request){
        DB::table('test')->insert(['fields' => $request->fields]);
        return response()->success();
    }
}
