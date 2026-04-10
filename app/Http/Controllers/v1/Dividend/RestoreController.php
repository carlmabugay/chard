<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\RestoreDividend;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(Dividend $dividend, RestoreDividend $use_case): JsonResponse
    {
        try {

            Gate::authorize('restore', $dividend);

            $result = $use_case->handle($dividend);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.restored', ['record' => 'Dividend']),
            ]);

        } catch (AuthorizationException) {

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
