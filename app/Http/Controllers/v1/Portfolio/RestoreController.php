<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\RestorePortfolio;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(Portfolio $portfolio, RestorePortfolio $use_case): JsonResponse
    {
        try {

            Gate::authorize('restore', $portfolio);

            $result = $use_case->handle($portfolio);

            return response()->json([
                'success' => $result,
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
