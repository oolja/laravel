<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class UserFilter extends ApiFilter
{
    protected array $filterable = [
        'id' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'name' => ['eq'],
        'email' => ['eq'],
        'type' => ['eq', 'ne'],
        'phone' => ['eq'],
    ];

    protected array $sortable = ['id', 'name'];
}
