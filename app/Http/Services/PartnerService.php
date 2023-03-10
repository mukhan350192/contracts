<?php

namespace App\Http\Services;

use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerService
{
    protected int $merchantID = 538153;
    protected string $url = 'https://api.paybox.money/payment.php';

    public function create(
        string      $name,
        string      $phone,
        string      $password,
        string|null $company_name,
        string      $company_type,
        string|null $address,
    )
    {
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
        if (!$balance) {
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
            'pg_merchant_id' => 517822,//our id in Paybox, will be gived on contract
            'pg_amount' => $amount, //amount of payment
            'pg_salt' => "Salt", //amount of payment
            'pg_order_id' => $userID, //id of purchase, strictly unique
            'pg_description' => $description, //will be shown to client in process of payment, required
            'pg_result_url' => 'api.mircreditov.kz/api/payment_result',//route('payment-result')
            'pg_success_url' => $success_url,
        ];
        ksort($data);
        array_unshift($data, 'payment.php');
        array_push($data, 'vKuygqBoLgE7dxDp');

        $data['pg_sig'] = md5(implode(';', $data));

        unset($data[0], $data[1]);

        $query = http_build_query($data);
        return response()->success(['url' => $this->url . $query]);
    }
}
