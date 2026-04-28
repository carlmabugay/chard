<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Domain\Portfolio\DTOs\RestorePortfolioDTO;
use App\Domain\Portfolio\Processes\RestorePortfolioProcess;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestorePortfolioProcess $process,
    ) {}

    public function __invoke(Portfolio $portfolio): JsonResponse
    {
        try {

            Gate::authorize('restore', $portfolio);

            $dto = new RestorePortfolioDTO(
                id: $portfolio->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.restored', ['record' => 'Portfolio']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
