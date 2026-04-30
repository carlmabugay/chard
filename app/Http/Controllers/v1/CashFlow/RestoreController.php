<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Domain\CashFlow\DTOs\RestoreCashFlowDTO;
use App\Domain\CashFlow\Process\RestoreCashFlowProcess;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestoreCashFlowProcess $process,
    ) {}

    public function __invoke(CashFlow $cash_flow): JsonResponse
    {
        try {

            Gate::authorize('restore', $cash_flow);

            $dto = new RestoreCashFlowDTO(
                id: $cash_flow->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.restored', ['record' => 'Cash flow']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
