<?php

namespace App\Http\Controllers;

use App\Http\Services\VerigramService;
use Illuminate\Http\Request;

class VerigramController extends Controller
{
    public function getAccessToken(VerigramService $service){
        return $service->getToken();
    }
}
