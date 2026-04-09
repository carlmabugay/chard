<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\RestoreStrategy;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Http\JsonResponse;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(Strategy $strategy, RestoreStrategy $use_case): JsonResponse
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
