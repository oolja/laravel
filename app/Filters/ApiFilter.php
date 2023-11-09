<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
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

    public function __construct(
        public readonly Request $request,
    )
    {
    }

    /**
     * @return array<int, array<int,string>>
     */
    public function transform(): array
    {
        $eloQuery = [];

        foreach ($this->filterable as $param => $operators) {
            if (!$this->request->has($param)) {
                continue;
            }

            $query = $this->request->query($param);
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

    /**
     * @return array<int, string>
     */
    public function include(): array
    {
        if (!$this->request->has('include')) {
            return [];
        }

        $include = $this->request->query('include');

        if (is_string($include)) {
            return explode(',', $include);
        }

        return [];
    }
}
