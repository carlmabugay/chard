<?php

namespace App\Http\Controllers\v1\User;

use App\Application\User\UseCases\AuthenticateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Throwable;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, AuthenticateUser $use_case)
    {
        try {

            $result = $use_case->handle($request->validated());

            if (! $result) {
                return response([
                    'message' => 'Invalid login credentials',
                ], 401);
            }

            return response([
                'token' => $result,
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
