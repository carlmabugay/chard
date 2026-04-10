<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\TrashDividend;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(Dividend $dividend, TrashDividend $use_case): JsonResponse
    {
        try {

            Gate::authorize('trash', $dividend);

            $result = $use_case->handle($dividend);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.trashed', ['record' => 'Dividend']),
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
