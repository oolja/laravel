<?php

namespace App\Http\Requests\V1;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $uniqueEmail = 'unique:users';

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            /** @var User $user */
            $user = $this->route('user');
            $id = $user->id;
            $uniqueEmail .= ",email,$id";
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', $uniqueEmail, 'email', 'max:255'],
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
