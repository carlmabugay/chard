<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\UseCases\RestoreDividendInterface;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(Dividend $dividend, RestoreDividendInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('restore', $dividend);

            $dto = DividendDTO::fromModel($dividend);

            $result = $use_case->handle($dto);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.restored', ['record' => 'Dividend']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
