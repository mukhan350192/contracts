<?php

namespace App\Http\Controllers;

use App\Http\Services\PartnerService;
use App\Models\ShortURL;
use Illuminate\Http\Request;

class PartnerSMSController extends Controller
{
    /**
     * @param Request $request
     * @param PartnerService $service
     * @return string
     */
    public function getSendingSMS(PartnerService $service){
        return $service->getSendingSMS(auth()->user()->id);
    }
    /***
     * @param Request $request
     * @param PartnerService $service
     * @return string
     */

    public function getSigningSMS(Request $request){
        return response()->success(['data'=>ShortURL::with('signHistory')->where('user_id',$request->userID)->get()]);
    }
}
