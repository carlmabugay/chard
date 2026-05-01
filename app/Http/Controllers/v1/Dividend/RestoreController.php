<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Domain\Dividend\DTOs\RestoreDividendDTO;
use App\Domain\Dividend\Process\RestoreDividendProcess;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __construct(
        protected readonly RestoreDividendProcess $process
    ) {}

    public function __invoke(Dividend $dividend): JsonResponse
    {
        try {

            Gate::authorize('restore', $dividend);

            $dto = new RestoreDividendDTO(
                id: $dividend->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.restored', ['record' => 'Dividend']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
