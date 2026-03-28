<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\ListDividends;
use App\Domain\Common\Query\Filter;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Common\Query\Sort;
use App\Enums\OperatorType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dividend\DividendCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListDividends $use_case): DividendCollection|JsonResponse
    {
        try {

            $criteria = new QueryCriteria(
                page: request('page', 1),
                per_page: request('per_page', 15),

                search: request('search'),

                filters: [
                    new Filter('amount', OperatorType::EQ->value, request('amount')),
                ],

                sorts: [
                    new Sort('created_at', request('direction', 'desc')),
                ],
            );

            $result = $use_case->handle($criteria);

            return DividendCollection::make($result['data'])->additional([
                'success' => true,
                'pagination' => $result['pagination'],
            ]);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
