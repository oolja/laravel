<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApiFilter
{
    /**
     * @var array<string, array<int, string>>
     */
    protected array $filterable = [];
    /**
     * @var array<string, string>
     */
    protected array $columnMap = [];

    /**
     * @var array<int, string>
     */
    protected array $sortable = [];

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

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function sort(Builder $builder): Builder
    {
        if (!$this->request->has('sort')) {
            return $builder;
        }

        $sort = $this->request->query('sort');
        if (!is_string($sort)) {
            return $builder;
        }

        $fields = explode(',', $sort);

        foreach ($fields as $field) {
            $column = ltrim($field, '-');
            if (!in_array($column, $this->sortable)) {
                continue;
            }

            $direction = ($field[0] === '-') ? 'desc' : 'asc';
            $column = $this->columnMap[$column] ?? $column;

            $builder->orderBy($column, $direction);
        }

        return $builder;
    }
}
