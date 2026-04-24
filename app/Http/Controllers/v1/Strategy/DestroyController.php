<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\DTOs\DeleteStrategyDTO;
use App\Domain\Strategy\Processes\DeleteStrategyProcess;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __construct(
        protected readonly DeleteStrategyProcess $process,
    ) {}

    public function __invoke(Strategy $strategy): JsonResponse
    {
        try {

            Gate::authorize('destroy', $strategy);

            $dto = new DeleteStrategyDTO(
                id: $strategy->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.destroyed', ['record' => 'Strategy']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
