<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Domain\Dividend\Contracts\UseCases\DeleteDividendInterface;
use App\Http\Controllers\Controller;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __invoke(Dividend $dividend, DeleteDividendInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('destroy', $dividend);

            $result = $use_case->handle($dividend);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.destroyed', ['record' => 'Dividend']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
