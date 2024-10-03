<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PmsUserRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if (request()->method() == 'POST') {
            return [
                'fname' => 'required|string|min:2|max:30',
                'lname' => 'required|string|min:2|max:30',
                'subdomain' => 'required|alpha_num|unique:companies,subdomain',
                'email' => 'required|string|email:rfc,dns|unique:users,email',
                'password' => 'required|string|min:6',
                'confirm_password' => 'same:password'
            ];
        }

        return [];
    }
}
