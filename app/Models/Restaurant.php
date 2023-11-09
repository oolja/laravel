<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurant extends Model
{
    use HasFactory;

     protected $fillable = ['user_id', 'name'];

    /**
     * @return BelongsTo<User, Restaurant>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
