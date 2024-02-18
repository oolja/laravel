<?php

declare(strict_types=1);

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class ItemFilter extends ApiFilter
{
    protected array $filterable = [
        'id' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'name' => ['eq'],
        'imageId' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'price' => ['eq', 'ne', 'lt', 'lte', 'gt', 'gte'],
        'active' => ['eq']
    ];

    protected array $sortable = ['id', 'name', 'price', 'priority'];

    protected array $columnMap = [
        'categoryId' => 'category_id',
        'imageId' => 'image_id',
        'categoriesActive' => 'categories.active',
        'categoriesRestaurantId' => 'categories.restaurant_id'
    ];
}
