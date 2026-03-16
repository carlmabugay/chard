<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\DTOs\StorePortfolioDTO;
use App\Application\UseCases\StorePortfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Http\Resources\PortfolioResource;
use Illuminate\Support\Arr;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(UpdatePortfolioRequest $request, StorePortfolio $use_case)
    {
        try {

            $data = Arr::add($request->validated(), 'user_id', $request->user()->id);

            $dto = StorePortfolioDTO::fromArray($data);

            $result = $use_case->handle($dto);

            return new PortfolioResource($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage(), $error->getCode());
        }
    }
}
