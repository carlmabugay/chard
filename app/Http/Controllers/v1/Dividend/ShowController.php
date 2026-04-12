<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Domain\Dividend\Contracts\UseCases\GetDividendInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dividend\DividendResource;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(Dividend $dividend, GetDividendInterface $use_case): DividendResource|JsonResponse
    {
        try {

            Gate::authorize('view', $dividend);

            $result = $use_case->handle($dividend);

            return DividendResource::make($result);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
