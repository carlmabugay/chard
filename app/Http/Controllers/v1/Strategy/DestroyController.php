<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\DeleteStrategy;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class DestroyController extends Controller
{
    public function __invoke(int $id, DeleteStrategy $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'error' => 'Strategy not found to delete.',
                'message' => sprintf('Strategy with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
