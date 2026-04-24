<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\DTOs\RestoreStrategyDTO;
use App\Domain\Strategy\Processes\RestoreStrategyProcess;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestoreStrategyProcess $process,
    ) {}

    public function __invoke(Strategy $strategy): JsonResponse
    {
        try {

            Gate::authorize('restore', $strategy);

            $dto = new RestoreStrategyDTO(
                id: $strategy->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.restored', ['record' => 'Strategy']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }

    }
}
