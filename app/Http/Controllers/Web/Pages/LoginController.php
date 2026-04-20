<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('login/index');
    }
}
