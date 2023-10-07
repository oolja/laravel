<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Http\Request;

abstract class ApiFilter
{
    /**
     * @var array<string, array<string>>
     */
    protected array $filterable = [];
    /**
     * @var array<string, string>
     */
    protected array $columnMap = [];

    //TODO Maybe move operator map in child classes? Find way to support IN and LIKE operators
    /**
     * @var array<string, string>
     */
    protected array $operatorMap = [
        'eq' => '=',
        'ne' => '!=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];

    /**
     * @param Request $request
     * @return array<int, array<int,string>>
     */
    public function transform(Request $request): array
    {
        $eloQuery = [];

        foreach ($this->filterable as $param => $operators) {
            if (!$request->has($param)) {
                continue;
            }

            $query = $request->query($param);
            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (!isset($query[$operator])) {
                    continue;
                }
                $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
            }
        }

        return $eloQuery;
    }
}
