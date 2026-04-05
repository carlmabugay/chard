<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\UseCases\GetPortfolio;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Models\Portfolio;
use App\Traits\HasModelNotFoundExceptionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    use HasModelNotFoundExceptionResponse;

    public function __invoke(int $id, GetPortfolio $use_case): PortfolioResource|JsonResponse
    {
        try {

            $result = $use_case->handle($id);

            return PortfolioResource::make($result);

        } catch (ModelNotFoundException) {

            return $this->modelNotFoundResponse(Portfolio::class, $id);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
