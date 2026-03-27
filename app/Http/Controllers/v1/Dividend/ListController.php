<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\ListDividends;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dividend\DividendCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ListController extends Controller
{
    public function __invoke(ListDividends $use_case): DividendCollection|JsonResponse
    {
        try {

            $result = $use_case->handle();

            return DividendCollection::make($result['data'])->additional([
                'success' => true,
                'pagination' => $result['pagination'],
            ]);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
