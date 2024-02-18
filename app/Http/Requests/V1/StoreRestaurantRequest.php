<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'integer'],
            'imageId' => ['sometimes', 'integer'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        //TODO Maybe refactor this condition to be more flexible
        if ($this->userId) {
            $this->merge([
                'user_id' => $this->userId
            ]);
        }

        if ($this->imageId) {
            $this->merge([
                'image_id' => $this->imageId
            ]);
        }
    }
}
