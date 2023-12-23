<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'description' => ['sometimes', 'string', 'max:1024'],
            'price' => ['required', 'decimal:2'],
            'active' => ['required', 'boolean'],
            'categories' => ['sometimes', 'array'],
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
