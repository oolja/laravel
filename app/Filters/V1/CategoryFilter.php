<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CategoryFilter extends ApiFilter
{
    protected array $filterable = [
        'id' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'restaurantId' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'name' => ['eq'],
        'active' => ['eq']
    ];

    protected array $sortable = ['id', 'restaurantId', 'name', 'priority'];

    protected array $columnMap = [
        'restaurantId' => 'restaurant_id',
    ];
}
