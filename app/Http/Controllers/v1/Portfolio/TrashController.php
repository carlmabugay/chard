<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Domain\Portfolio\DTOs\TrashPortfolioDTO;
use App\Domain\Portfolio\Processes\TrashPortfolioProcess;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __construct(
        protected TrashPortfolioProcess $process,
    ) {}

    public function __invoke(Portfolio $portfolio): JsonResponse
    {
        try {

            Gate::authorize('trash', $portfolio);

            $dto = new TrashPortfolioDTO(
                id: $portfolio->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.trashed', ['record' => 'Portfolio']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
