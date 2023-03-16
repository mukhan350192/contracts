<?php

namespace App\Http\Controllers;

use App\Http\Services\VerigramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerigramController extends Controller
{
    public function getAccessToken(VerigramService $service)
    {
        return $service->getToken();
    }

    public function fields(Request $request, VerigramService $service)
    {
        return $service->fields($request->firstName, $request->gender, $request->iin, $request->lastName, $request->middleName, $request->originalImage, $request->facePicture, $request->shortID, $request->phone);
    }
}
