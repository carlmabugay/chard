<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\TrashDividend;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(Dividend $dividend, TrashDividend $use_case): JsonResponse
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
