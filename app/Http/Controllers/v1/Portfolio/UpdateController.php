<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Application\Portolio\UseCases\StorePortfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\UpdatePortfolioRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(Portfolio $portfolio, UpdatePortfolioRequest $request, StorePortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {

            Gate::authorize('update', $portfolio);

            $dto = new StorePortfolioDTO(
                user_id: auth()->id(),
                name: $request->validated('name'),
            );

            $result = $use_case->handle($dto);

            return new PortfolioResource($result);

        } catch (AuthorizationException) {

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
