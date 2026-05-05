<?php

namespace App\Http\Controllers\Site\Pages\Dividend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{
    public function __invoke(): Response
    {

        return Inertia::render('dividend/create/index');
    }
}
