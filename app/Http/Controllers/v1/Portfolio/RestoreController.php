<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\RestorePortfolio;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(int $id, RestorePortfolio $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Portfolio not found to restore.',
                'message' => sprintf('Portfolio with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
