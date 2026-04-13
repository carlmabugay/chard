<?php

namespace App\Http\Controllers\v1\Strategy;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\UseCases\DeleteStrategyInterface;
use App\Http\Controllers\Controller;
use App\Models\Strategy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class DestroyController extends Controller
{
    public function __invoke(Strategy $strategy, DeleteStrategyInterface $use_case): JsonResponse
    {
        try {

            Gate::authorize('destroy', $strategy);

            $dto = StrategyDTO::fromModel($strategy);

            $result = $use_case->handle($dto);

            return response()->json([
                'success' => $result,
                'message' => __('messages.success.destroyed', ['record' => 'Strategy']),
            ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
