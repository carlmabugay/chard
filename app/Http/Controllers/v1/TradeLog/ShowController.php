<?php

namespace App\Http\Controllers\V1\TradeLog;

use App\Application\TradeLog\UseCases\GetTradeLog;
use App\Http\Controllers\Controller;
use App\Http\Resources\TradeLog\TradeLogResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    public function __invoke(int $id, GetTradeLog $use_case): TradeLogResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return TradeLogResource::make($result);

        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Trade log not found',
                'message' => sprintf('Trade log with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
