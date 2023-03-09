<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Requests\PartnerRequest;
use App\Http\Requests\SignRequest;
use App\Http\Services\PartnerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param PartnerRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function create(PartnerRequest $request, PartnerService $service): JsonResponse
    {
        return $service->create($request->name, $request->phone, $request->password, $request->company_name, $request->company_type, $request->address);
    }

    /**
     * @param DocumentRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function addDocs(DocumentRequest $request, PartnerService $service): JsonResponse
    {
        //var_dump(auth()->user());
        return $service->addDocs($request->documents, auth()->user()->id);
    }

    public function sign(SignRequest $request,PartnerService $service){
        return $service->sign($request->phone,$request->password);
    }
}
