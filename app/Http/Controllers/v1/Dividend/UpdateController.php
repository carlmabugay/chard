<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\DTOs\StoreDividendDTO;
use App\Application\Dividend\UseCases\StoreDividend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dividend\UpdateDividendRequest;
use App\Http\Resources\Dividend\DividendResource;
use App\Models\Dividend;
use Illuminate\Http\JsonResponse;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(Dividend $dividend, UpdateDividendRequest $request, StoreDividend $use_case): DividendResource|JsonResponse
    {
        try {

            $dto = StoreDividendDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return DividendResource::make($result);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
