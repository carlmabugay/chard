<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Inertia\Inertia;

class StrategyController extends Controller
{
    public function __invoke()
    {

        $strategies = Strategy::latest()->get();

        return Inertia::render('strategy/index', [
            'strategies' => $strategies,
        ]);
    }
}
