<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\UseCases\GetStrategy;
use App\Http\Controllers\Controller;
use App\Http\Resources\StrategyResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(int $id, GetStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return StrategyResource::make($result);

        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Strategy not found',
                'message' => sprintf('Strategy with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());

        }
    }
}
