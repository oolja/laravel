<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $rules = [
            'restaurantId' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
            'priority' => ['sometimes', 'integer'],
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

    protected function prepareForValidation(): void
    {
        //TODO Maybe refactor this condition to be more flexible
        if ($this->restaurantId) {
            $this->merge([
                'restaurant_id' => $this->restaurantId
            ]);
        }
    }
}
