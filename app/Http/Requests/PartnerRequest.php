<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $name string
 * @property $phone string
 * @property $iin string|null
 * @property $password string
 * @property $company_name string|null
 * @property $company_type string
 * @property $bin string|null
 * @property $code integer
 */
class PartnerRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string|min:6',
            'code' => 'required|integer',
        ];
    }
}
