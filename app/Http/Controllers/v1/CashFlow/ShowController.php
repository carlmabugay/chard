<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlowResource;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(CashFlow $cash_flow): CashFlowResource|JsonResponse
    {
        try {

            Gate::authorize('view', $cash_flow);

            return CashFlowResource::make($cash_flow)
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
