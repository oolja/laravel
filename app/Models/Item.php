<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'active'];

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
}
