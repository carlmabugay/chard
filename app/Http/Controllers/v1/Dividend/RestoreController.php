<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\RestoreDividend;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class RestoreController extends Controller
{
    public function __invoke(int $id, RestoreDividend $use_case): JsonResponse
    {

        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'error' => 'Dividend not found to restore.',
                'message' => sprintf('Dividend with ID: %s not found', $id),
            ], 404);
        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
