<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\UseCases\StoreStrategyInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use App\Http\Resources\StrategyResource;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(Strategy $strategy, StoreStrategyRequest $request, StoreStrategyInterface $use_case): StrategyResource|JsonResponse
    {
        try {

            Gate::authorize('update', $strategy);

            $request->merge(['id' => $strategy->id]);

            $dto = StrategyDTO::fromRequest($request);

            $result = $use_case->handle($dto);

            return new StrategyResource($result)
                ->additional([
                    'message' => __('messages.success.updated', ['record' => 'Strategy']),
                ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
