<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\UseCases\RestoreTradeLog;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

class RestoreController extends Controller
{
    public function __invoke(int $id, RestoreTradeLog $use_case): JsonResponse
    {

        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Trade log not found to restore.',
                'message' => sprintf('Trade log with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
