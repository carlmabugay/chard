<?php

namespace App\Http\Controllers\v1\User;

use App\Application\User\UseCases\AuthenticateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Throwable;

final class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, AuthenticateUser $use_case)
    {
        try {

            $result = $use_case->handle($request);

            if (! $result) {
                return response([
                    'message' => 'Invalid login credentials.',
                ], 401);
            }

            $response = [
                'success' => true,
            ];

            if (is_string($result)) {
                $response['token'] = $result;
            }

            return response($response);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
