<?php

namespace App\Domain\User\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function authenticate(Request $request): bool|string
    {

        if (! Auth::attempt($request->only(['email', 'password']))) {
            return false;
        }

        if ($request->is('api/*')) {
            return Auth::user()->createToken('API Token')->plainTextToken;
        }

        $request->session()->regenerate();

        return true;
    }

    public function logout(Request $request): void
    {
        if ($request->is('api/*')) {
            $request->user()->tokens()->delete();
            auth()->guard('sanctum')->forgetUser();
        } else {
            auth()->guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
