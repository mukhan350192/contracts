<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerRequest;
use App\Http\Requests\SignRequest;
use App\Http\Services\PartnerService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * @param PartnerRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function create(PartnerRequest $request, PartnerService $service): JsonResponse
    {
        return $service->create($request->name, $request->phone, $request->password, $request->company_name, $request->company_type, $request->bin, $request->code, $request->iin);
    }

    /**
     * @param SignRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */

    public function sign(SignRequest $request, PartnerService $service): JsonResponse
    {
        return $service->sign($request->phone, $request->password);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        return response()->success();
    }

    /***
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        return User::profile(auth()->user()->id);

    }

}
