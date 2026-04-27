<?php

namespace App\Http\Controllers\Site\Pages\Portfolio;

use App\Domain\Portfolio\DTOs\StorePortfolioDTO;
use App\Domain\Portfolio\Processes\StorePortfolioProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StorePortfolioRequest;
use Illuminate\Support\Facades\Redirect;

class StoreController extends Controller
{
    public function __construct(
        protected StorePortfolioProcess $process
    ) {}

    public function __invoke(StorePortfolioRequest $request)
    {

        $dto = new StorePortfolioDTO(
            user_id: $request->user()->id,
            name: $request->validated('name'),
        );

        $this->process->run(
            payload: $dto,
        );

        return Redirect::route('portfolio.index')
            ->with('success', __('messages.success.stored', ['record' => 'Portfolio']));

    }
}
