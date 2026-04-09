<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\RestorePortfolio;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(Portfolio $portfolio, RestorePortfolio $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($portfolio);

            return response()->json([
                'success' => $result,
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
