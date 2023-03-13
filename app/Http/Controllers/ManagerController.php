<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentCheckRequest;
use App\Http\Requests\ManagerRequest;
use App\Http\Services\ManagerService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * @param ManagerRequest $request
     * @return JsonResponse
     */
    public function create(ManagerRequest $request)
    {
        return User::addManager($request->name, $request->phone, $request->password);
    }

    /**
     * @param DocumentCheckRequest $request
     * @param ManagerService $service
     * @return JsonResponse
     */
    public function approve(DocumentCheckRequest $request, ManagerService $service): JsonResponse
    {
        return $service->approve($request->documentID);
    }

    public function getAll(Request $request, ManagerService $service):JsonResponse{
        return $service->getAll(auth()->user()->id);
    }
}
