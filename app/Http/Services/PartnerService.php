<?php

namespace App\Http\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerService
{
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

    public function addDocs(array $docs, int $userID)
    {
        foreach ($docs as $doc) {

            $fileName = sha1(Str::random(50)) . "." . $doc['doc']->extension();
            $doc['doc']->storeAs('uploads', $fileName, 'public');
            $doc['doc']->move(public_path('uploads'), $fileName);
            DB::table('documents')->insert([
                'user_id' => $userID,
                'document' => $fileName,
                'name' => $doc['name'],
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        return response()->success();
    }

    public function sign(string $phone, string $password)
    {
        $user = User::where('phone', $phone)->first();
        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->with('error', 'Неправильный логин или пароль');
        }
        $token = $user->createToken('api', ['partner'])->plainTextToken;

        $docs = DB::table('documents')->where('user_id', $user->id)->get();
        return view('partner-page', ['token' => $token, 'docs' => $docs, 'user' => $user]);
    }
}
