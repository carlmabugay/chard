<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\GetStrategy;
use App\Http\Controllers\Controller;
use App\Http\Resources\Strategy\StrategyResource;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(Strategy $strategy, GetStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            Gate::authorize('view', $strategy);

            $result = $use_case->handle($strategy);

            return StrategyResource::make($result);

        } catch (AuthorizationException) {

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
