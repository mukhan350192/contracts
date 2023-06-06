<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentCheckRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\SMSRequest;
use App\Http\Services\PartnerDocumentService;
use App\Http\Services\PartnerService;
use App\Models\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerDocumentController extends Controller
{
    /**
     * @param DocumentRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function addDocs(DocumentRequest $request, PartnerDocumentService $service): JsonResponse
    {
        return $service->addDocs($request->doc, $request->name, auth()->user()->id);
    }

    /**
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function getActiveDocs(PartnerDocumentService $service): JsonResponse
    {
        return $service->getActiveDocs(auth()->user()->id);
    }

    /***
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function getDocs(PartnerDocumentService $service): JsonResponse
    {
        return $service->getDocs(auth()->user()->id);
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
     * @param DocumentCheckRequest $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function approve(DocumentCheckRequest $request,PartnerDocumentService $service): JsonResponse{
        return $service->approveDoc($request->documentID);
    }
}
