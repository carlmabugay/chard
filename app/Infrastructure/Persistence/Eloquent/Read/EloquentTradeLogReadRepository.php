<?php

namespace App\Infrastructure\Persistence\Eloquent\Read;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Infrastructure\Persistence\Eloquent\Query\EloquentQueryApplier;
use App\Infrastructure\Persistence\Pagination\LaravelPaginatorAdapter;
use App\Models\TradeLog as TradeLogModel;
use App\Traits\HasEloquentSearchable;

class EloquentTradeLogReadRepository implements TradeLogReadRepositoryInterface
{
    use HasEloquentSearchable;

    const array SEARCHABLE_COLUMNS = [
        'symbol',
    ];

    public function findAll(QueryCriteria $criteria): array
    {
        $query = TradeLogModel::query()->with('portfolio');

        $query = EloquentQueryApplier::apply(
            $query,
            $criteria,
            fn ($query, $search) => $this->applySearch($query, $search, self::SEARCHABLE_COLUMNS)
        );

        $paginator = $query->paginate(
            perPage: $criteria->per_page,
            page: $criteria->page,
        );

        $result = LaravelPaginatorAdapter::fromPaginator(
            $paginator,
            fn (TradeLogModel $model) => TradeLog::fromEloquentModel($model)
        );

        return $result->toArray();
    }
}
