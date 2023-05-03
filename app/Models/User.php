<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'phone',
        'user_type',
        'password',
        'iin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function addManager(string $name, string $phone, string $password): JsonResponse
    {
        $user = User::create([
            'name' => $name,
            'phone' => $phone,
            'password' => bcrypt($password),
            'user_type' => 3,

        ]);
        $token = $user->createToken('api', ['manager'])->plainTextToken;
        return response()->success(['token' => $token]);
    }

    public static function addLawyer(string $name, string $phone, string $password): JsonResponse
    {
        $user = User::create([
            'name' => $name,
            'phone' => $phone,
            'password' => bcrypt($password),
            'user_type' => 4,

        ]);
        $token = $user->createToken('api', ['lawyer'])->plainTextToken;
        return response()->success(['token' => $token]);
    }

    /***
     * @param int $id
     * @return JsonResponse
     */
    public static function profile(int $id): JsonResponse{
        return response()->success([User::where('id',$id)->select('name','phone','iin')->first()]);
    }

    public function transactions(){
        return $this->hasMany(BalanceHistory::class,'user_id','id');
    }
}
