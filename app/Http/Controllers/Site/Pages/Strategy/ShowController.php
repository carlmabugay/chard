<?php

namespace App\Http\Controllers\Site\Pages\Strategy;

use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

final class ShowController extends Controller
{
    public function __invoke(Strategy $strategy): Response
    {
        Gate::authorize('view', $strategy);

        return Inertia::render('strategy/show', $strategy);
    }
}
