<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Contracts\UseCases\StorePortfolioInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StorePortfolioRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(StorePortfolioRequest $request, StorePortfolioInterface $use_case): PortfolioResource|JsonResponse
    {
        try {

            $dto = PortfolioDTO::fromRequest($request);

            $result = $use_case->handle($dto);

            return new PortfolioResource($result)
                ->additional([
                    'message' => __('messages.success.stored', ['record' => 'Portfolio']),
                ])
                ->response()
                ->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
