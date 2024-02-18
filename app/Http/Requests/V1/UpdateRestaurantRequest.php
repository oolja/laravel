<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
            'userId' => ['required', 'integer'],
            'imageId' => ['sometimes', 'integer'],
            'name' => ['required', 'string', 'max:255'],
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
