<?php

namespace App\Domain\User\Services;

use Illuminate\Support\Facades\Auth;

class UserService
{
    public function authenticate(array $credentials): bool|string
    {
        if (! Auth::attempt($credentials)) {
            return false;
        }

        return Auth::user()->createToken('API Token')->plainTextToken;
    }
}
