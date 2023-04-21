<?php

namespace App\Http\Services;

use App\Models\Payment;
use App\Models\ShortURL;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PartnerService
{
    public string $url = "http://nash-crm.kz/api/contracts/createLead.php";

    /**
     * @param string $name
     * @param string $phone
     * @param string $password
     * @param string|null $company_name
     * @param string|null $company_type
     * @param string|null $address
     * @param int $code
     * @param string $iin
     * @return JsonResponse
     */

    public function create(
        string      $name,
        string      $phone,
        string      $password,
        string|null $company_name,
        string|null $company_type,
        string|null $bin,
        int         $code,
        string|null      $iin
    ): JsonResponse
    {
        $user = User::where('phone', $phone)->first();
        if ($user) {
            return response()->fail('Пользователь уже зарегистрирован');
        }
        $check = DB::table('sms_confirmation')->where('phone', $phone)->where('code', $code)->first();
        if (!$check) {
            return response()->fail('Код не совпадает');
        }
        $user = User::create([
            'name' => $name,
            'phone' => $phone,
            'password' => $password,
            'user_type' => 1,
            'iin' => $iin,
        ]);
        if (!$user) {
            return response()->fail('Попробуйте позже');
        }
        $token = $user->createToken('api', ['partner'])->plainTextToken;
        if (!$company_type != 1) {
            DB::table('partner_contacts')->insert([
                'company_name' => $company_name,
                'company_type' => $company_type,
                'bin' => $bin,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        $this->sendToBitrix($name, $phone, $password, $code, $iin, $company_name, $company_type, $bin);
        return response()->success(['token' => $token]);
    }

    /**
     * @param $name
     * @param $phone
     * @param $password
     * @param $code
     * @param $iin
     * @param $company_name
     * @param $company_type
     * @param $address
     * @return bool
     */

    public function sendToBitrix($name, $phone, $password, $code, $iin, $company_name, $company_type, $bin)
    {
        $url = $this->url . "?name={$name}&phone={$phone}&password={$password}&code={$code}&iin={$iin}&company_name={$company_name}&company_type={$company_type}&bin={$bin}";
        $http = Http::withoutVerifying()->get($url);
        if ($http->status() == 200) {
            return true;
        }
        return false;
    }


    /**
     * @param $doc
     * @param string $name
     * @param int $userID
     * @return JsonResponse
     */
    public function addDocs($doc, string $name, int $userID): JsonResponse
    {
        $fileName = sha1(Str::random(50)) . "." . $doc->extension();
        $doc->storeAs('uploads', $fileName, 'public');
        $doc->move(public_path('uploads'), $fileName);
        DB::table('documents')->insert([
            'user_id' => $userID,
            'document' => $fileName,
            'name' => $name,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response()->success();
    }

    /**
     * @param string $phone
     * @param string $password
     * @return JsonResponse
     */
    public function sign(string $phone, string $password): JsonResponse
    {
        $user = User::where('phone', $phone)->first();
        if (!Hash::check($password, $user->password)) {
            return response()->fail('Неправильный логин или пароль');
        }
        $user_types = [
            1 => 'partner',
            2 => 'client',
            3 => 'manager',
        ];
        $token = $user->createToken('api', [$user_types[$user->user_type]])->plainTextToken;
        $docs = [
            'token' => $token,
            'success' => true,
            'type' => $user->user_type,
        ];
        return response()->success($docs);
    }

    /**
     * @param int $userID
     * @return JsonResponse
     */
    public function getDocs(int $userID): JsonResponse
    {
        $doc = DB::table('documents')->where('user_id', $userID)->get()->toArray();
        if (!$doc) {
            return response()->fail('Пока у вас нету документов');
        }
        $data['doc'] = $doc;
        return response()->success($data);
    }

    /**
     * @param int $userID
     * @return JsonResponse
     */
    public function getActiveDocs(int $userID): JsonResponse
    {
        $doc = DB::table('documents')->where('user_id', $userID)->where('status', 1)->get()->toArray();
        if (!$doc) {
            return response()->fail('Пока у вас нету документов');
        }


        $balance = DB::table('balance')->where('user_id', $userID)->first();
        if (!$balance || $balance->amount < 1) {
            return response()->fail('У вас не хватает баланса');
        }
        $data['doc'] = $doc;
        return response()->success($data);
    }

    /**
     * @param int $userID
     * @param string $amount
     * @return JsonResponse
     */
    public function payment(int $userID, string $amount): JsonResponse
    {
        $success_url = 'api.mircreditov.kz';
        $description = 'Оплата за услугу';
        $data = [
            'extra_user_id' => $userID,
            'pg_merchant_id' => env('MERCHANT_ID'),//our id in Paybox, will be gived on contract
            'pg_amount' => $amount, //amount of payment
            'pg_salt' => "Salt", //amount of payment
            'pg_order_id' => $userID, //id of purchase, strictly unique
            'pg_description' => $description, //will be shown to client in process of payment, required
            'pg_result_url' => env('RESULT_URL'),//route('payment-result')
            'pg_success_url' => $success_url,
        ];
        ksort($data);
        array_unshift($data, 'payment.php');
        array_push($data, env('PAYMENT_KEY'));

        $data['pg_sig'] = md5(implode(';', $data));

        unset($data[0], $data[1]);

        $query = http_build_query($data);
        return response()->success(['url' => env('PAYBOX_URL') . '?' . $query]);
    }

    /**
     * @param int $extra_user_id
     * @param float $pg_amount
     * @param string $transaction_id
     * @return JsonResponse
     */

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
        $balances = DB::table('balance')->where('user_id', $extra_user_id)->first();
        if (!$balances) {
            DB::table('balance')->insertGetId([
                'amount' => $pg_amount,
                'user_id' => $extra_user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $balances->increment('amount', $pg_amount);
        }

        $balance = DB::table('balance_history')->where('user_id', $extra_user_id)->orderByDesc('created_at')->first();
        $before = 0;
        if ($balance) {
            $before = $balance->balance_before;
        }

        DB::table('balance_history')->insert([
            'status' => 'income',
            'amount' => $pg_amount,
            'balance_before' => $before,
            'balance_after' => $before + $pg_amount,
            'user_id' => $extra_user_id,
            'description' => 'Пополнение',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response()->success();
    }

    /**
     * @param int $userID
     * @param string $phone
     * @param string $iin
     * @param int $smsID
     * @param int $documentID
     * @return string
     */
    public function send(int $userID, string $phone, string $iin, int $smsID, int $documentID): string
    {

        $token = Str::random(16);
        ShortURL::query()->create([
            'document_id' => $documentID,
            'token' => $token,
            'user_id' => $userID,
            'phone' => $phone,
            'iin' => $iin,
        ]);
        $link = 'https://api.mircreditov.kz/sign/' . $token;
        $messages = [
            [
                'notifyUrl' => route('infobip'),
                'from' => 'ICREDITKZ',
                'text' => 'Для подтверждение договора перейдите по ссылке ' . $link,
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

        $balance = DB::table('balance_history')->where('user_id', $userID)->orderByDesc('created_at')->first();
        $before = 0;
        if ($balance) {
            $before = $balance->balance_before;
        }
        DB::table('balance')->where('user_id', $userID)->decrement('amount', 1);
        DB::table('balance_history')->insertGetId([
            'status' => 'expenditure',
            'amount' => 0,
            'balance_before' => $before,
            'balance_after' => $before - 1,
            'description' => 'Отправка смс',
            'user_id' => $userID,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return isset($response['messages'][0]['status']['groupId'])
            && in_array($response['messages'][0]['status']['groupId'], [1, 3]);

    }
}
