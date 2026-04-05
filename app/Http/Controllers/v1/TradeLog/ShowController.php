<?php

namespace App\Http\Controllers\V1\TradeLog;

use App\Application\TradeLog\UseCases\GetTradeLog;
use App\Http\Controllers\Controller;
use App\Http\Resources\TradeLog\TradeLogResource;
use App\Models\TradeLog;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, GetTradeLog $use_case): TradeLogResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return TradeLogResource::make($result);

        } catch (ModelNotFoundException) {

            return $this->modelNotFoundResponse(TradeLog::class, $id);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
