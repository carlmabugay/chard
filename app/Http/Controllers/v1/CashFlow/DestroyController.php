<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Domain\CashFlow\DTOs\DeleteCashFlowDTO;
use App\Domain\CashFlow\Process\DeleteCashFlowProcess;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __construct(
        protected readonly DeleteCashFlowProcess $process
    ) {}

    public function __invoke(CashFlow $cash_flow): JsonResponse
    {
        try {

            Gate::authorize('destroy', $cash_flow);

            $dto = new DeleteCashFlowDTO(
                id: $cash_flow->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.destroyed', ['record' => 'Cash flow']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
