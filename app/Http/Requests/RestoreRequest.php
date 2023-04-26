<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $userID integer
 * @property $restoreID integer
 * @property $password string
 */
class RestoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'userID' => 'required|integer|exists:users,id',
            'restoreID' => 'required|integer|exists:restore_url,id',
            'password' => 'required|string|min:8',
        ];
    }
}
