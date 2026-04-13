<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Contracts\UseCases\RestorePortfolioInterface;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(Portfolio $portfolio, RestorePortfolioInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('restore', $portfolio);

            $dto = PortfolioDTO::fromModel($portfolio);

            $result = $use_case->handle($dto);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.restored', ['record' => 'Portfolio']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
