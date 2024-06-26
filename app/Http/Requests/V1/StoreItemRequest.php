<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:1024'],
            'imageId' => ['sometimes', 'integer'],
            'price' => ['required', 'decimal:2'],
            'active' => ['required', 'boolean'],
            'categories' => ['sometimes', 'array'],
        ];
    }

    protected function prepareForValidation(): void
    {
        //TODO Maybe refactor this condition to be more flexible
        if ($this->imageId) {
            $this->merge([
                'image_id' => $this->imageId,
            ]);
        }
    }
}
