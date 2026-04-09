<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\RestoreDividend;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Http\JsonResponse;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(Dividend $dividend, RestoreDividend $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($dividend);

            return response()->json([
                'success' => $result,
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
