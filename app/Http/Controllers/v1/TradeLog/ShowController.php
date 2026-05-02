<?php

namespace App\Http\Controllers\V1\TradeLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\TradeLogResource;
use App\Models\TradeLog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(TradeLog $trade_log): TradeLogResource|JsonResponse
    {
        try {

            Gate::authorize('view', $trade_log);

            return TradeLogResource::make($trade_log)
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
