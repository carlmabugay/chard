<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TradeLogController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('trade-log/index');
    }
}
