<?php

namespace App\Http\Controllers\v1\Portfolio;

use App\Application\DTOs\SavePortfolioDTO;
use App\Application\UseCases\SavePortfolio;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePortfolioRequest;
use Illuminate\Support\Arr;

final class StoreController extends Controller
{
    public function __invoke(
        CreatePortfolioRequest $request,
        SavePortfolio $use_case
    ) {

        $data = Arr::add($request->validated(), 'user_id', $request->user()->id);

        $dto = SavePortfolioDTO::fromArray($data);

        $use_case->handle($dto);
    }
}
