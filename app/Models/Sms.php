<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Sms extends Model
{
    use HasFactory;

    protected $table = 'sms';
    protected $fillable = [
        'phone',
        'status',
        'message',
        'type',
    ];

    public static function createCode(string $phone){
        return Sms::query()->insertGetId([
            'phone' => $phone,
            'status' => 1,
            'message' => 'Для подтверждение кода',
            'type' => 1,
        ]);
    }

    public static function make(int $userID,string $phone){
        return Sms::query()->insertGetId([
           'user_id' => $userID,
           'phone' => $phone,
        ]);
    }



    public static function send(string $phone){
        $code = rand(1000,9999);

        $user = User::where('phone',$phone)->first();
        if ($user){
            return response()->fail('Пользователь уже зарегистрован');
        }
        $smsID = DB::table('sms_confirmation')->insertGetId([
           'code' => $code,
           'phone' => $phone,
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
        $messages = [
            [
                'notifyUrl' => route('infobip'),
                'from' => env('ALPHANAME'),
                'text' => 'Код подтверджение '.$code,
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
                'Authorization' => 'App '.env('BIPKEY'),
            ])->asJson()->post('/sms/2/text/advanced', [
                'messages' => $messages,
            ]);

        $response = $request->json();
        return isset($response['messages'][0]['status']['groupId'])
            && in_array($response['messages'][0]['status']['groupId'], [1, 3]);
    }
}
