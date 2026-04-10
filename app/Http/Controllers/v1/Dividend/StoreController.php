<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\DTOs\StoreDividendDTO;
use App\Application\Dividend\UseCases\StoreDividend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dividend\CreateDividendRequest;
use App\Http\Resources\Dividend\DividendResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateDividendRequest $request, StoreDividend $use_case): DividendResource|JsonResponse
    {
        try {

            $dto = StoreDividendDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return DividendResource::make($result)
                ->additional([
                    'message' => __('messages.success.stored', ['record' => 'Dividend']),
                ])
                ->response()
                ->setStatusCode(201);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
