<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Http\Controllers\Controller;
use App\Http\Resources\DividendResource;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(Dividend $dividend): DividendResource|JsonResponse
    {
        try {

            Gate::authorize('view', $dividend);

            return DividendResource::make($dividend)
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
