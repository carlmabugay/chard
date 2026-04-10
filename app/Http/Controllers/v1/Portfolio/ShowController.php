<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\GetPortfolio;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(Portfolio $portfolio, GetPortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {

            Gate::authorize('view', $portfolio);

            $result = $use_case->handle($portfolio);

            return PortfolioResource::make($result);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
