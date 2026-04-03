<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\UseCases\TrashTradeLog;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(int $id, TrashTradeLog $use_case)
    {

        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Trade log not found to delete.',
                'message' => sprintf('Trade log with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
