<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class ImageFilter extends ApiFilter
{
    protected array $filterable = [
        'id' => ['ne', 'lt', 'lte', 'gt', 'gte'],
        'image' => ['eq'],
    ];

    protected array $sortable = ['id'];
}
