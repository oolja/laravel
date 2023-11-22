<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class RestaurantFilter extends ApiFilter
{
    protected array $filterable = [
        'id' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'userId' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'name' => ['eq'],
    ];

    protected array $sortable = ['id', 'userId', 'name'];

    protected array $columnMap = [
        'userId' => 'user_id',
    ];
}
