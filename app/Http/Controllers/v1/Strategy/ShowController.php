<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Http\Controllers\Controller;
use App\Http\Resources\StrategyResource;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(Strategy $strategy): StrategyResource|JsonResponse
    {
        try {

            Gate::authorize('view', $strategy);

            return StrategyResource::make($strategy)
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
