<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'name', 'active', 'priority'];

    /**
     * The model's default values for attributes.
     *
     * @var array{active: bool, priority: int}
     */
    protected $attributes = [
        'active' => false,
        'priority' => 0,
    ];

    /**
     * @return BelongsTo<Restaurant, Category>
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * @return BelongsToMany<Item>
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('priority');
    }
}
