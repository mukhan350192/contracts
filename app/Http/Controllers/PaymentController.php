<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Services\PartnerService;
use App\Http\Services\PaymentService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @param PaymentRequest $request
     * @param PaymentService $service
     * @return JsonResponse
     */
    public function paymentResult(PaymentRequest $request, PaymentService $service): JsonResponse
    {
        return $service->paymentResult($request->extra_user_id, $request->pg_amount, $request->pg_payment_id);
    }

    /**
     * @param Request $request
     * @param PartnerService $service
     * @return JsonResponse
     */
    public function transaction(){
        return response()->success(['data'=>User::with('transactions')->where('id',auth()->user()->id)->first()]);
    }
}
