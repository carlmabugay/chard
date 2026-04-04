<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\TrashPortfolio;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    public function __invoke(int $id, TrashPortfolio $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);
        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Portfolio not found to delete.',
                'message' => sprintf('Portfolio with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }

    }
}
