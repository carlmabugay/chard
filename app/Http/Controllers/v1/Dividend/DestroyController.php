<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\DeleteDividend;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Http\JsonResponse;
use Throwable;

final class DestroyController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(Dividend $dividend, DeleteDividend $use_case): JsonResponse
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
