<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

abstract class Controller
{
    public function errorResponse(string $message, int $code = 500)
    {
        Log::error($message);

        return response()->json([
            'success' => false,
            'error' => 'An unexpected error occurred. Please try again later.',
            'message' => $message,
        ], $code);
    }

    public function unauthorizedResponse(?string $message = null, int $code = 401)
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? __('messages.unauthorized'),
        ], $code);
    }
}
