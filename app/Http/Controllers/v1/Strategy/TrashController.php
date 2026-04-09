<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\TrashStrategy;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(Strategy $strategy, TrashStrategy $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($strategy);

            return response()->json([
                'success' => $result,
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
