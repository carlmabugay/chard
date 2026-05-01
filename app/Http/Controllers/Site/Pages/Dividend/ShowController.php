<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Http\Resources\DividendResource;
use App\Models\Dividend;
use Illuminate\Support\Facades\Gate;

final class ShowController
{
    public function __invoke(Dividend $dividend)
    {
        Gate::authorize('view', $dividend);

        return DividendResource::make($dividend);
    }
}
