<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhonePartnerRequest;
use App\Http\Requests\RestoreRequest;
use App\Http\Services\PartnerService;
use App\Http\Services\PasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * @param PhonePartnerRequest $request
     * @param PartnerService $service
     * @return boolean
     */
    public function remember_password(PhonePartnerRequest $request, PasswordService $service): bool
    {
        return $service->remember_password($request->phone);
    }


    /**
     * @param RestoreRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */

    public function restore_password(RestoreRequest $request, PasswordService $service): JsonResponse
    {
        return $service->restore_password($request->userID, $request->password, $request->restoreID);
    }

}
