<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\TrashCashFlow;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, TrashCashFlow $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {

            return $this->modelNotFoundResponse(CashFlow::class, $id);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
