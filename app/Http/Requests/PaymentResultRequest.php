<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $extra_user_id integer
 * @property $pg_amount double
 * @property $pg_payment_id string
 */
class PaymentResultRequest extends FormRequest
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
            'extra_user_id' => 'required|integer|exists:users,id',
            'pg_amount' => 'required',
            'pg_payment_id' => 'required'
        ];
    }
}
