<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\ListPortfolios;
use App\Domain\Common\Query\QueryCriteria;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PortfolioCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListPortfolios $use_case): PortfolioCollection|JsonResponse
    {
        try {
            $criteria = new QueryCriteria(
                page: request('page', 1),
                per_page: request('per_page', 15),

                search: request('search'),
            );

            $result = $use_case->handle($criteria);

            return PortfolioCollection::make($result['data'])->additional([
                'success' => true,
                'pagination' => $result['pagination'],
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }

    }
}
