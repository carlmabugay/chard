<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\RestoreStrategy;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class RestoreController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, RestoreStrategy $use_case): JsonResponse
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
