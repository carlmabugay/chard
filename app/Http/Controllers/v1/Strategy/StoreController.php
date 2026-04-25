<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\DTOs\CreateStrategyDTO;
use App\Domain\Strategy\Processes\CreateStrategyProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __construct(
        protected readonly CreateStrategyProcess $process,
    ) {}

    public function __invoke(StoreStrategyRequest $request): JsonResponse
    {
        try {

            $dto = new CreateStrategyDTO(
                user_id: $request->user()->id,
                name: $request->validated('name'),
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.stored', ['record' => 'Strategy']),
            ])->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
