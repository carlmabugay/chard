<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\TrashPortfolio;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TrashController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, TrashPortfolio $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {

            return $this->modelNotFoundResponse(Portfolio::class, $id);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
