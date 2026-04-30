<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Domain\CashFlow\DTOs\TrashCashFlowDTO;
use App\Domain\CashFlow\Process\TrashCashFlowProcess;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __construct(
        protected TrashCashFlowProcess $process,
    ) {}

    public function __invoke(CashFlow $cash_flow): JsonResponse
    {
        try {

            Gate::authorize('trash', $cash_flow);

            $dto = new TrashCashFlowDTO(
                id: $cash_flow->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.trashed', ['record' => 'Cash flow']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
