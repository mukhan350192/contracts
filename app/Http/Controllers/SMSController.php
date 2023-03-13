<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Illuminate\Http\Request;
const SMS_STATUS_QUEUED = 100;
const SMS_STATUS_DELIVERED = 102;
const SMS_STATUS_EXPIRED = 103;
const SMS_STATUS_UNDELIVERABLE = 105;
const SMS_STATUS_ERROR = 200;

class SMSController extends Controller
{
    public function infobip(Request $request){
        $data = json_decode($request->getContent(), true);

        $statusMapping = [
            'PENDING' => SMS_STATUS_QUEUED,
            'EXPIRED' => SMS_STATUS_EXPIRED,
            'DELIVERED' => SMS_STATUS_DELIVERED,
            'UNDELIVERABLE' => SMS_STATUS_UNDELIVERABLE,
            'REJECTED' => SMS_STATUS_ERROR,
        ];

        if (isset($data['results']) && count($data['results'])) {
            foreach ($data['results'] as $item) {
                if (! isset($item['messageId']) || ! isset($item['status']['groupName'])) {
                    continue;
                }

                Sms::query()->find($item['messageId'])->update([
                    'status' => $statusMapping[$item['status']['groupName']] ?? SMS_STATUS_ERROR,
                ]);
            }
        }

        return response()->noContent();
    }


    public function send(Request $request){

        return Sms::send($request->phone);
    }
}
