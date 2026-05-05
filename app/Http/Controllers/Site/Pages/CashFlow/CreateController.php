<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CreateController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('cash-flow/create/index');
    }
}
