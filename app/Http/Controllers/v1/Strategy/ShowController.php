<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\UseCases\GetStrategy;
use App\Http\Controllers\Controller;
use App\Http\Resources\Strategy\StrategyResource;
use App\Models\Strategy;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, GetStrategy $use_case): StrategyResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return StrategyResource::make($result);

        } catch (ModelNotFoundException) {

            return $this->modelNotFoundResponse(Strategy::class, $id);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
