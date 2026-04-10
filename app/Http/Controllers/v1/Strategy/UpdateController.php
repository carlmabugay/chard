<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Application\Strategy\UseCases\StoreStrategy;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\UpdateStrategyRequest;
use App\Http\Resources\Strategy\StrategyResource;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(Strategy $strategy, UpdateStrategyRequest $request, StoreStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            Gate::authorize('update', $strategy);

            $dto = new StoreStrategyDTO(
                user_id: auth()->id(),
                name: $request->validated('name'),
                id: $strategy->id,
            );

            $result = $use_case->handle($dto);

            return new StrategyResource($result);

        } catch (AuthorizationException) {

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
