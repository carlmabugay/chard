<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Domain\Dividend\DTOs\TrashDividendDTO;
use App\Domain\Dividend\Process\TrashDividendProcess;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __construct(
        protected readonly TrashDividendProcess $process,
    ) {}

    public function __invoke(Dividend $dividend): JsonResponse
    {
        try {

            Gate::authorize('trash', $dividend);

            $dto = new TrashDividendDTO(
                id: $dividend->id,
            );

            $this->process->run(
                payload: $dto,
            );

            return response()->json([
                'success' => true,
                'message' => __('messages.success.trashed', ['record' => 'Dividend']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
