<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Contracts\UseCases\TrashPortfolioInterface;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(Portfolio $portfolio, TrashPortfolioInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('trash', $portfolio);

            $dto = PortfolioDTO::fromModel($portfolio);

            $result = $use_case->handle($dto);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.trashed', ['record' => 'Portfolio']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
