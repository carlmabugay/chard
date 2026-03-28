<?php

namespace App\Infrastructure\Persistence\Eloquent\Query;

use App\Domain\Common\Query\QueryCriteria;
use App\Enums\OperatorType;
use Illuminate\Database\Eloquent\Builder;

class EloquentQueryApplier
{
    public static function apply(Builder $query, QueryCriteria $criteria): Builder
    {
        if ($criteria->search) {
            $query->where(function (Builder $query) use ($criteria) {
                $query->where('symbol', 'like', '%'.$criteria->search.'%');
            });
        }

        foreach ($criteria->filters as $filter) {
            match ($filter->operator) {
                OperatorType::EQ->value => $query->where($filter->field, '=', $filter->value),
                OperatorType::LIKE->value => $query->where($filter->field, 'like', $filter->value.'%'),
                OperatorType::GT->value => $query->where($filter->field, '>', $filter->value),
                OperatorType::GTE->value => $query->where($filter->field, '>=', $filter->value),
                OperatorType::LT->value => $query->where($filter->field, '<', $filter->value),
                OperatorType::LTE->value => $query->where($filter->field, '<=', $filter->value),
                OperatorType::IN->value => $query->whereIn($filter->field, $filter->value),
                OperatorType::BETWEEN->value => $query->whereBetween($filter->field, $filter->value),
            };
        }

        foreach ($criteria->sorts as $sort) {
            $query->orderBy($sort->field, $sort->direction);
        }

        return $query;
    }
}
