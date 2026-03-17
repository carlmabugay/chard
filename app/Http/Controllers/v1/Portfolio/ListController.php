<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\UseCases\ListPortfolios;
use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListPortfolios $use_case): PortfolioCollection|JsonResponse
    {
        try {
            $result = $use_case->handle();

            return PortfolioCollection::make($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());

        }

    }
}
