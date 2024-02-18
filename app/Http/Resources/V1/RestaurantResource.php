<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'imageId' => $this->image_id,
            'name' => $this->name,
            'user' => UserResource::make($this->whenLoaded('user')),
            'image' => ImageResource::make($this->whenLoaded('image')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories'))
        ];
    }
}
