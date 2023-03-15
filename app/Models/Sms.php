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

    protected $table = 'sms_history';
    protected $fillable = [
        'user_id',
        'phone',
        'status'
    ];

    public static function make(int $userID,string $phone){
        return Sms::query()->insertGetId([
           'user_id' => $userID,
           'phone' => $phone,
        ]);
    }

    public static function send(string $phone){
        $code = rand(1000,9999);
        $smsID = DB::table('sms_confirmation')->insertGetId([
           'code' => $code,
           'phone' => $phone,
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ]);
        $messages = [
            [
                'notifyUrl' => route('infobip'),
                'from' => 'ICREDITKZ',
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
        return response()->success();
    }
}
