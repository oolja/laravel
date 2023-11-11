<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
        /** @var User $user */
        $user = $this->route('user');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', "unique:users,email,$user->id", 'email', 'max:255'],
            'phone' => ['nullable', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()]
        ];

        if ($this->method() === 'PATCH') {
            foreach ($rules as $key => $rule) {
                if (in_array('sometimes', $rule)) {
                    continue;
                }
                $rules[$key][] = 'sometimes';
            }
        }

        return $rules;
    }
}
