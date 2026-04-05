<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\DeleteStrategy;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class DestroyController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, DeleteStrategy $use_case): JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return response()->json([
                'success' => $result,
            ]);

        } catch (ModelNotFoundException) {

            return $this->modelNotFoundResponse(Strategy::class, $id);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
