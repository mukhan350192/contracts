<?php

namespace App\Http\Controllers;

use App\Http\Requests\clientRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\PartnerRequest;
use App\Http\Requests\PaymentResultRequest;
use App\Http\Requests\SignRequest;
use App\Http\Requests\SMSRequest;
use App\Http\Services\ClientService;
use App\Http\Services\ManagerService;
use App\Http\Services\PartnerService;
use App\Models\Sms;
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
        return $service->create($request->name, $request->phone, $request->password, $request->company_name, $request->company_type, $request->bin, $request->code, $request->iin);
    }

    /**
     * @param DocumentRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function addDocs(DocumentRequest $request, PartnerService $service): JsonResponse
    {
        //var_dump(auth()->user());
        return $service->addDocs($request->doc, $request->name, auth()->user()->id);
    }

    public function sign(SignRequest $request, PartnerService $service)
    {
        return $service->sign($request->phone, $request->password);
    }

    public function getDocs(PartnerService $service)
    {
        return $service->getDocs(auth()->user()->id);
    }

    public function getActiveDocs(PartnerService $service)
    {
        return $service->getActiveDocs(auth()->user()->id);
    }

    public function payment(Request $request, PartnerService $service)
    {
        return $service->payment(auth()->user()->id, $request->amount);
    }

    public function paymentResult(Request $request, PartnerService $service)
    {
        if (!$request->extra_user_id || !$request->pg_amount || !$request->pg_payment_id) {
            return response()->fail('Попробуйте позже');
        }
        return $service->paymentResult($request->extra_user_id, $request->pg_amount, $request->pg_payment_id);
    }

    public function send(SMSRequest $request, PartnerService $service)
    {
        // var_dump($request);
        $smsID = Sms::make(auth()->user()->id, $request->phone);
        //var_dump($smsID);
        return $service->send(auth()->user()->id, $request->phone, $request->iin, $smsID, $request->document_id);
    }

    public function clientCreate(clientRequest $request, ClientService $service): JsonResponse
    {
        return $service->create($request->iin, $request->password, $request->phone, $request->id);
    }

    public function getClientDocs(ClientService $service)
    {
        return $service->clientDocs(auth()->user()->id);
    }

    public function managerCreate(Request $request, ManagerService $service)
    {
        return $service->create($request->phone,$request->password,$request->iin,$request->name);
    }

    public function logout(){
        $user = auth()->user();
        $s = $user->currentAccessToken()->delete();
        return response()->success();

    }
}
