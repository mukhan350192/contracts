<?php

namespace App\Http\Services;

use App\Models\Payment;
use App\Models\ShortURL;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PartnerService
{
    protected int $merchantID = 538153;
    protected string $url = 'https://api.paybox.money/payment.php';
    protected string $paymentKey = 'hbmWS9krWO1Sd57Z';
    protected string $result_url = 'https://api.mircreditov.kz/api/paymentResult';

    protected string $infobipURL = 'https://xr5ep4.api.infobip.com';
    protected string $key = '5aec06024478c7dc093f9ebcb40059d6-7b002e63-a891-48b4-a4c5-2edb3c065926';

    public function create(
        string      $name,
        string      $phone,
        string      $password,
        string|null $company_name,
        string      $company_type,
        string|null $address,
        int         $code
    )
    {
        $check = DB::table('sms_confirmation')->where('phone',$phone)->where('code',$code)->first();
        if (!$check){
            return response()->fail('Код не совпадает');
        }
        $user = User::create([
            'name' => $name,
            'phone' => $phone,
            'password' => $password,
            'user_type' => 1,
        ]);
        if (!$user) {
            return response()->fail('Попробуйте позже');
        }
        $token = $user->createToken('api', ['partner'])->plainTextToken;
        DB::table('partner_contacts')->insert([
            'company_name' => $company_name,
            'company_type' => $company_type,
            'address' => $address,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->route('partner-page', ['token' => $token]);
    }

    public function addDocs($doc, string $name, int $userID)
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

    public function sign(string $phone, string $password)
    {
        $user = User::where('phone', $phone)->first();
        if (!Hash::check($password, $user->password)) {
            return response()->fail('Неправильный логин или пароль');
        }
        $token = $user->createToken('api', ['partner'])->plainTextToken;


        $docs = [
            'token' => $token,
            'success' => true,
        ];
        return response()->success($docs);
    }

    public function getDocs(int $userID)
    {
        $doc = DB::table('documents')->where('user_id', $userID)->get()->toArray();
        if (!$doc) {
            return response()->fail('Пока у вас нету документов');
        }
        $data['doc'] = $doc;
        return response()->success($data);
    }

    public function getActiveDocs(int $userID)
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

    public function payment(int $userID, string $amount)
    {
        $success_url = 'api.mircreditov.kz';
        $description = 'Оплата за услугу';
        $data = [
            'extra_user_id' => $userID,
            'pg_merchant_id' => $this->merchantID,//our id in Paybox, will be gived on contract
            'pg_amount' => $amount, //amount of payment
            'pg_salt' => "Salt", //amount of payment
            'pg_order_id' => $userID, //id of purchase, strictly unique
            'pg_description' => $description, //will be shown to client in process of payment, required
            'pg_result_url' => $this->result_url,//route('payment-result')
            'pg_success_url' => $success_url,
        ];
        ksort($data);
        array_unshift($data, 'payment.php');
        array_push($data, $this->paymentKey);

        $data['pg_sig'] = md5(implode(';', $data));

        unset($data[0], $data[1]);

        $query = http_build_query($data);
        return response()->success(['url' => $this->url . '?' . $query]);
    }

    public function paymentResult(int $extra_user_id, float $pg_amount, string $transaction_id)
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

    public function send(int $userID, string $phone, string $iin, int $smsID, int $documentID)
    {

        $token = Str::random(16);
        ShortURL::query()->create([
            'document_id' => $documentID,
            'token' => $token,
            'user_id' => $userID,
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
            ->baseUrl($this->infobipURL)
            ->withHeaders([
                'Authorization' => 'App ' . $this->key,
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
            'balance_before' => $before - 1,
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
