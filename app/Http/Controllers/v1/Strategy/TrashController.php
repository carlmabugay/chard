<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\TrashStrategy;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(Strategy $strategy, TrashStrategy $use_case): JsonResponse
    {
        try {

            Gate::authorize('trash', $strategy);

            $result = $use_case->handle($strategy);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.trashed', ['record' => 'Strategy']),
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
