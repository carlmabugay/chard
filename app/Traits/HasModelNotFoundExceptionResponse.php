<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

trait HasModelNotFoundExceptionResponse
{
    public function modelNotFoundResponse(string $model, int $id): JsonResponse
    {
        $model_name = ucfirst(Str::snake(class_basename($model), ' '));

        return response()->json([
            'success' => false,
            'error' => sprintf('%s not found.', $model_name),
            'message' => sprintf('%s with ID: [%s] not found.', $model_name, $id),
        ], 404);
    }
}
