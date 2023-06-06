<?php

namespace App\Http\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordService
{
    /**
     * @param string $phone
     * @return boolean
     */
    public function remember_password(string $phone)
    {
        $token = Str::random(8);
        $link = 'https://api.mircreditov.kz/restore/' . $token;
        $message = 'Для восстановление пароля перейдите по ссылке ' . $link;

        $smsID = DB::table('sms')->insertGetId([
            'phone' => $phone,
            'message' => $message,
            'type' => 2,
        ]);
        $userID = User::where('phone', $phone)->select('id')->first();
        DB::table('restore_url')->insertGetId([
            'token' => $token,
            'user_id' => $userID->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $sms = new SmsService();


        if ($sms->send($message,$phone,$smsID)){
            return response()->success();
        }
        return response()->fail('Попробуйте позже');
    }

    /**
     * @param int $userID
     * @param string $password
     * @param int $restoreID
     * @return JsonResponse
     */

    public function restore_password(int $userID, string $password, int $restoreID):JsonResponse
    {
        DB::table('restore_url')->where('id', $restoreID)->update(['status' => true, 'updated_at' => Carbon::now()]);
        $update = User::where('id', $userID)->update(['password' => bcrypt($password)]);
        if (!$update) {
            return response()->fail('Попробуйте позже');
        }
        return response()->success();
    }
}
