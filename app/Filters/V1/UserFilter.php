<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class UserFilter extends ApiFilter
{
    protected array $filterable = [
        'id' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'name' => ['eq'],
        'email' => ['eq'],
        'phone' => ['eq'],
    ];
}
