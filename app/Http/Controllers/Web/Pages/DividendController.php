<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DividendController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('dividend/index');
    }
}
