<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Http\Controllers\Controller;
use App\Http\Resources\StrategyResource;
use App\Models\Strategy;
use Illuminate\Support\Facades\Gate;

final class ShowController extends Controller
{
    public function __invoke(Strategy $strategy): StrategyResource
    {
        Gate::authorize('view', $strategy);

        return StrategyResource::make($strategy);
    }
}
