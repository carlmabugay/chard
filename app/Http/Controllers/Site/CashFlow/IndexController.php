<?php

namespace App\Http\Controllers\Site\CashFlow;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke()
    {

        return Inertia::render('cash-flow/index', []);
    }
}
