<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\UseCases\StoreDividendInterface;
use App\Domain\Portfolio\Contracts\Services\PortfolioServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Http\Resources\Dividend\DividendResource;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateDividendRequest $request, StoreDividendInterface $use_case, PortfolioServiceInterface $portfolio_service): DividendResource|JsonResponse
    {
        try {

            $portfolio = $portfolio_service->findById($request->validated('portfolio_id'));

            Gate::authorize('store', [Dividend::class, $portfolio->toEloquentModel()]);

            $dto = DividendDTO::fromRequest($request);

            $result = $use_case->handle($dto);

            return DividendResource::make($result)
                ->additional([
                    'message' => __('messages.success.stored', ['record' => 'Dividend']),
                ])
                ->response()
                ->setStatusCode(201);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
