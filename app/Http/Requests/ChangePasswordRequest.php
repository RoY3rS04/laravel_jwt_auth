<?php

namespace App\Http\Requests;

use App\Rules\AuthPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'max:255', new AuthPasswordRule],
            'password_new' => ['required', 'string', 'max:255'],
            'password_confirm' => ['required', 'string', 'max:255', 'same:password_new']
        ];
    }
}
