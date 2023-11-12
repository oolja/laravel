<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'name', 'active', 'priority'];

    /**
     * @return BelongsTo<Restaurant, Category>
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
