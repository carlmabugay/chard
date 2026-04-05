<?php

namespace App\Http\Controllers\v1\TradeLog;

use App\Application\TradeLog\UseCases\TrashTradeLog;
use App\Http\Controllers\Controller;
use App\Models\TradeLog;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, TrashTradeLog $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {

            return $this->modelNotFoundResponse(TradeLog::class, $id);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
