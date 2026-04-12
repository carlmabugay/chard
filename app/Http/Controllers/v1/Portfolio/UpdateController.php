<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Domain\Portfolio\Contracts\UseCases\StorePortfolioInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StorePortfolioRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(Portfolio $portfolio, StorePortfolioRequest $request, StorePortfolioInterface $use_case): PortfolioResource|JsonResponse
    {
        try {

            Gate::authorize('update', $portfolio);

            $dto = new StorePortfolioDTO(
                user_id: auth()->id(),
                name: $request->validated('name'),
                id: $portfolio->id,
            );

            $result = $use_case->handle($dto);

            return new PortfolioResource($result)->additional([
                'message' => __('messages.success.updated', ['record' => 'Portfolio']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
