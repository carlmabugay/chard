<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Domain\Portfolio\DTOs\StorePortfolioDTO;
use App\Domain\Portfolio\Processes\StorePortfolioProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StorePortfolioRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __construct(
        protected StorePortfolioProcess $process,
    ) {}

    public function __invoke(StorePortfolioRequest $request): JsonResponse
    {
        try {

            $dto = new StorePortfolioDTO(
                user_id: $request->user()->id,
                name: $request->validated('name')
            );

            $result = $this->process->run(
                payload: $dto,
            );

            return response()
                ->json([
                    'success' => true,
                    'message' => __('messages.success.stored', ['record' => 'Portfolio']),
                ])
                ->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
