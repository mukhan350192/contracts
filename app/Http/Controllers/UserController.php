<?php

namespace App\Http\Controllers;

use App\Http\Requests\clientRequest;
use App\Http\Requests\DocumentCheckRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\PartnerRequest;
use App\Http\Requests\PaymentResultRequest;
use App\Http\Requests\PhonePartnerRequest;
use App\Http\Requests\RestoreRequest;
use App\Http\Requests\SignRequest;
use App\Http\Requests\SMSRequest;
use App\Http\Services\ClientService;
use App\Http\Services\ManagerService;
use App\Http\Services\PartnerService;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
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
     * @param DocumentRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function addDocs(DocumentRequest $request, PartnerService $service): JsonResponse
    {
        return $service->addDocs($request->doc, $request->name, auth()->user()->id);
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

    /***
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function getDocs(PartnerService $service): JsonResponse
    {
        return $service->getDocs(auth()->user()->id);
    }

    /**
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function getActiveDocs(PartnerService $service): JsonResponse
    {
        return $service->getActiveDocs(auth()->user()->id);
    }

    /**
     * @param Request $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function payment(Request $request, PartnerService $service): JsonResponse
    {
        return $service->payment(auth()->user()->id, $request->amount);
    }


    /**
     * @param Request $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function paymentResult(Request $request, PartnerService $service): JsonResponse
    {
        if (!$request->extra_user_id || !$request->pg_amount || !$request->pg_payment_id) {
            return response()->fail('Попробуйте позже');
        }
        return $service->paymentResult($request->extra_user_id, $request->pg_amount, $request->pg_payment_id);
    }

    /**
     * @param SMSRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function send(SMSRequest $request, PartnerService $service): string
    {
        $smsID = Sms::make(auth()->user()->id, $request->phone);
        return $service->send(auth()->user()->id, $request->phone, $request->iin, $smsID, $request->document_id);
    }

    /**
     * @param clientRequest $request
     * @param ClientService $service
     * @return JsonResponse
     */
    public function clientCreate(clientRequest $request, ClientService $service): JsonResponse
    {
        return $service->create($request->iin, $request->password, $request->phone, $request->id);
    }

    /**
     * @param ClientService $service
     * @return JsonResponse
     */
    public function getClientDocs(ClientService $service): JsonResponse
    {
        return $service->clientDocs(auth()->user()->id);
    }

    /**
     * @param Request $request
     * @param ManagerService $service
     * @return JsonResponse
     */
    public function managerCreate(Request $request, ManagerService $service): JsonResponse
    {
        return $service->create($request->phone, $request->password, $request->iin, $request->name);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();
        $s = $user->currentAccessToken()->delete();
        return response()->success();

    }

    /**
     * @param PhonePartnerRequest $request
     * @param PartnerService $service
     * @return boolean
     */
    public function remember_password(PhonePartnerRequest $request, PartnerService $service): bool
    {
        return $service->remember_password($request->phone);
    }

    /**
     * @param RestoreRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */

    public function restore_password(RestoreRequest $request, PartnerService $service): JsonResponse
    {
        return $service->restore_password($request->userID, $request->password, $request->restoreID);
    }

    /***
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        return User::profile(auth()->user()->id);

    }

    public function approve(DocumentCheckRequest $request,PartnerService $service): JsonResponse{
        return $service->approveDoc($request->documentID);
    }

    public function getSendingSMS(Request $request,PartnerService $service){
        return $service->getSendingSMS($request->user()->id);
    }
}
