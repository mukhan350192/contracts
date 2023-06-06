<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $extra_user_id
 * @property string $pg_amount
 * @property string $pg_payment_id
 */

class PaymentRequest extends FormRequest
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
            'extra_user_id' => 'required|string',
            'pg_amount' => 'required|numeric',
            'pg_payment_id' => 'required|string',
        ];
    }
}
