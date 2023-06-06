<?php

namespace App\Http\Services;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function paymentResult(int $extra_user_id, float $pg_amount, string $transaction_id): JsonResponse
    {
        $payment = Payment::where('transaction_id', $transaction_id)->first();

        if ($payment && $payment->exists) {
            return response()->fail('Оплата уже есть');
        }
        Payment::create([
            'user_id' => $extra_user_id,
            'amount' => $pg_amount,
            'transaction_id' => $transaction_id,
        ]);

        $this->balance($pg_amount, $extra_user_id);
        $this->balanceHistory($pg_amount, $extra_user_id);

        return response()->success();
    }

    public function balanceHistory(float $amount, int $user_id): bool
    {
        return DB::table('balance_history')->insert([
            'status' => 'income',
            'amount' => $amount,
            'user_id' => $user_id,
            'description' => 'Пополнение',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function balance(float $amount, int $user_id)
    {
        $balances = DB::table('balance')->where('user_id', $user_id)->first();
        if (!$balances) {
            DB::table('balance')->insertGetId([
                'amount' => $amount,
                'user_id' => $user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->success();
        }
        $balances->increment('amount', $amount);
        return response()->success();
    }
}
