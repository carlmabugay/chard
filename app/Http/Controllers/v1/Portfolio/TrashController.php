<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\TrashPortfolio;
use App\Http\Controllers\Controller;
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

        } catch (Throwable $error) {
            return $this->errorResponse($error->getMessage());
        }

    }
}
