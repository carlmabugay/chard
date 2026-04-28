<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Domain\Portfolio\DTOs\UpdatePortfolioDTO;
use App\Domain\Portfolio\Processes\UpdatePortfolioProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StorePortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __construct(
        protected UpdatePortfolioProcess $process,
    ) {}

    public function __invoke(Portfolio $portfolio, StorePortfolioRequest $request): JsonResponse
    {
        try {

            Gate::authorize('update', $portfolio);

            $dto = new UpdatePortfolioDTO(
                id: $portfolio->id,
                name: $request->validated('name'),
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.updated', ['record' => 'Portfolio']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
