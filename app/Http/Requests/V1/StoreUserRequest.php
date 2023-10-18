<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users,email,' . $this->route('user')->id, 'email', 'max:255'],
            'phone' => ['nullable', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()]
        ];

        if ($this->method() !== 'PATCH') {
            return $rules;
        }

        foreach ($rules as $key => $rule) {
            if (in_array('sometimes', $rule)) {
                continue;
            }
            $rules[$key][] = 'sometimes';
        }

        return $rules;
    }
}
