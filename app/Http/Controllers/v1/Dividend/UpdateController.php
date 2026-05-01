<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Domain\Dividend\DTOs\UpdateDividendDTO;
use App\Domain\Dividend\Process\UpdateDividendProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dividend\UpdateDividendRequest;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __construct(
        protected readonly UpdateDividendProcess $process,
    ) {}

    public function __invoke(Dividend $dividend, UpdateDividendRequest $request): JsonResponse
    {
        try {

            Gate::authorize('update', $dividend);

            $dto = new UpdateDividendDTO(
                id: $dividend->id,
                portfolio_id: $request->validated('portfolio_id'),
                symbol: $request->validated('symbol'),
                amount: $request->validated('amount'),
                recorded_at: $request->validated('recorded_at'),
            );

            $this->process->run($dto);

            return response()->json([
                'success' => true,
                'message' => __('messages.success.updated', ['record' => 'Dividend']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
