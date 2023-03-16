<?php

namespace App\Http\Services;

use App\Models\VerigramSignHistory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VerigramService
{
    protected string $key = "PeeKMaNIX9dNL2pB2433rs7zwrs28gGZ";
    protected string $secret = "9ab3a51f7d5acbf20fc2a778516433bb";
    protected string $baseURL = "https://services.verigram.cloud";

    public function getToken()
    {
        $timestamp = time();
        $personID = Str::random(8);
        $path = "/resources/access-token?person_id=" . $personID;
        $url = $this->baseURL . $path;

        $signable_str = $timestamp . $path;

        $hmac_digest = hash_hmac('sha256', $signable_str, $this->secret, false);

        $ch = curl_init();

        $headers = array(
            'X-Verigram-Api-Version:1.1',
            "X-Verigram-Api-Key:$this->key",
            "X-Verigram-Hmac-SHA256:$hmac_digest",
            "X-Verigram-Ts:$timestamp",
        );

        $options = array(
            CURLOPT_SSL_VERIFYPEER => false,//for debug only
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => $url,
        );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $response = json_decode($response,true);
        return response()->success($response);
    }

    public function fields($firstName,$gender,$iin,$lastName,$middleName,$originalImage,$facePicture,$shortID,$phone){
        $original = base64_decode($originalImage);
        $originalName = sha1(Str::random(50)).".jpeg";
        Storage::disk('local/public/')->put($originalName, $original);

        $face = base64_decode($facePicture);
        $faceName = sha1(Str::random(50)).".jpeg";
        Storage::disk('local/public/')->put($faceName, $face);

        VerigramSignHistory::make($firstName,$gender,$iin,$lastName,$middleName,$originalName,$faceName,$shortID,$phone);
        return response()->success();
    }
}
