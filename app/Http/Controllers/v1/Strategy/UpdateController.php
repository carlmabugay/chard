<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\DTOs\StrategyRevisionDTO;
use App\Domain\Strategy\Processes\StrategyRevisionProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __construct(
        protected StrategyRevisionProcess $process
    ) {}

    public function __invoke(Strategy $strategy, StoreStrategyRequest $request): JsonResponse
    {
        try {

            Gate::authorize('update', $strategy);

            $dto = new StrategyRevisionDTO(
                id: $strategy->id,
                name: $request->validated('name'),
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.updated', ['record' => 'Strategy']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
