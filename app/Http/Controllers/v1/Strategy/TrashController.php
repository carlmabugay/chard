<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\DTOs\TrashStrategyDTO;
use App\Domain\Strategy\Processes\TrashStrategyProcess;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __construct(
        protected readonly TrashStrategyProcess $process,
    ) {}

    public function __invoke(Strategy $strategy): JsonResponse
    {
        try {

            Gate::authorize('trash', $strategy);

            $dto = new TrashStrategyDTO(
                id: $strategy->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.trashed', ['record' => 'Strategy']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
