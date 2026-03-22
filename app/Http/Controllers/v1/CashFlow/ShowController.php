<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\UserCases\GetCashFlow;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlow\CashFlowResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(int $id, GetCashFlow $use_case): CashFlowResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return CashFlowResource::make($result);

        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Cash flow not found',
                'message' => sprintf('Cash flow with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
