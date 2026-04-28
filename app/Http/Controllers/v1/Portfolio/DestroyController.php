<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Domain\Portfolio\DTOs\DeletePortfolioDTO;
use App\Domain\Portfolio\Processes\DeletePortfolioProcess;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __construct(
        protected readonly DeletePortfolioProcess $process,
    ) {}

    public function __invoke(Portfolio $portfolio): JsonResponse
    {
        try {

            Gate::authorize('destroy', $portfolio);

            $dto = new DeletePortfolioDTO(
                id: $portfolio->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.destroyed', ['record' => 'Portfolio']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
