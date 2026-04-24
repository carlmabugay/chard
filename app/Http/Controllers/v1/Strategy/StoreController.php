<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use App\Domain\Strategy\Processes\StrategyCreationProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __construct(
        private readonly StrategyCreationProcess $process,
    ) {}

    public function __invoke(StoreStrategyRequest $request): JsonResponse
    {
        try {

            $dto = new StrategyCreationDTO(
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
