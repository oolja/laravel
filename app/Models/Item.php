<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'image_id', 'price', 'active'];

    /**
     * The model's default values for attributes.
     *
     * @var array{active: bool}
     */
    protected $attributes = [
        'active' => false,
    ];

    /**
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withPivot('priority');
    }

    /**
     * @return BelongsTo<Image, Item>
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
