<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(Portfolio $portfolio): PortfolioResource|JsonResponse
    {
        try {

            Gate::authorize('view', $portfolio);

            return PortfolioResource::make($portfolio)
                ->additional([
                    'success' => true,
                ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
