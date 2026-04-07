<?php

namespace App\Http\Controllers\v1\User;

use App\Application\User\UseCases\LogoutUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;

final class LogoutController extends Controller
{
    public function __invoke(Request $request, LogoutUser $use_case)
    {
        try {

            $use_case->handle($request);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully.',
            ]);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
