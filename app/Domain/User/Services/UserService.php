<?php

namespace App\Domain\User\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\TransientToken;

class UserService
{
    public function authenticate(array $credentials): bool|string
    {
        if (! Auth::attempt($credentials)) {
            return false;
        }

        return Auth::user()->createToken('API Token')->plainTextToken;
    }

    public function logout(Request $request): void
    {
        $user = $request->user();

        // For mocked tests:
        if ($user->currentAccessToken() && ! ($user->currentAccessToken() instanceof TransientToken)) {
            $user->currentAccessToken()->delete();
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
