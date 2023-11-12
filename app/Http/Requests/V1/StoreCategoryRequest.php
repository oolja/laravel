<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        return [
            'restaurantId' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
            'priority' => ['sometimes', 'integer'],
        ];
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
