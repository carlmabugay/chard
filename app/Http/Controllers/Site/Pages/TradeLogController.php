<?php

namespace App\Http\Controllers\Site\Pages;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TradeLogController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('trade-log/index');
    }
}
