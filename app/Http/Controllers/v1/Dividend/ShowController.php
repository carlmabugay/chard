<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\UseCases\GetDividend;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dividend\DividendResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ShowController extends Controller
{
    public function __invoke(int $id, GetDividend $use_case): DividendResource|JsonResponse
    {

        try {

            $result = $use_case->handle($id);

            return DividendResource::make($result);

        } catch (ModelNotFoundException) {

            return response()->json([
                'success' => false,
                'error' => 'Dividend not found',
                'message' => sprintf('Dividend with ID: %s not found', $id),
            ], 404);

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());
        }
    }
}
