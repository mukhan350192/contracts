<?php

namespace App\Http\Services;

use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SMSService
{
    /***
     * @param int $phone
     * @return JsonResponse
     */

    public function sendCode(int $phone): JsonResponse
    {

        $smsID = Sms::createCode($phone);
        $code = rand(1000, 9999);
        $text = 'Код подтверджение ' . $code;

        if ($this->send($text, $phone, $smsID)) {
            $this->createConfirmationCode($phone, $code);
            return response()->success('Код отправлен');
        }

        return response()->fail('Ошибка отправки кода');
    }

    /**
     * @param string $text
     * @param string $phone
     * @param int $smsID
     * @param int $code
     * @return bool
     */
    public function send(string $text, string $phone, int $smsID): bool
    {
        $messages = [
            [
                'notifyUrl' => route('infobip'),
                'from' => env('ALPHANAME'),
                'text' => $text,
                'destinations' => [
                    [
                        'messageId' => $smsID,
                        'to' => $phone,
                    ],
                ],
            ],
        ];

        $request = Http::withoutVerifying()
            ->baseUrl(env('BIPURL'))
            ->withHeaders([
                'Authorization' => 'App ' . env('BIPKEY'),
            ])->asJson()->post('/sms/2/text/advanced', [
                'messages' => $messages,
            ]);

        $response = $request->json();
        if (isset($response['messages'][0]['status']['groupId']) && in_array($response['messages'][0]['status']['groupId'], [1, 3])) {
            return true;
        }
        return false;
    }

    public function createConfirmationCode(string $phone, int $code){
        DB::table('sms_confirmation')->insertGetId([
            'phone' => $phone,
            'code' => $code,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
