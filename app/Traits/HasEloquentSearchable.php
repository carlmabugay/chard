<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasEloquentSearchable
{
    public function applySearch(Builder $query, string $search, array $columns): void
    {
        $query->where(function ($q) use ($search, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'LIKE', "%{$search}%");
            }
        });
    }
}
