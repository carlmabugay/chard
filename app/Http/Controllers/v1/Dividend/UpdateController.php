<?php

namespace App\Http\Controllers\v1\Dividend;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\UseCases\StoreDividendInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dividend\UpdateDividendRequest;
use App\Http\Resources\Dividend\DividendResource;
use App\Models\Dividend;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class UpdateController extends Controller
{
    public function __invoke(Dividend $dividend, UpdateDividendRequest $request, StoreDividendInterface $use_case): DividendResource|JsonResponse
    {
        try {

            Gate::authorize('update', $dividend);

            $request->merge(['id' => $dividend->id]);

            $dto = DividendDTO::fromRequest($request);

            $result = $use_case->handle($dto);

            return DividendResource::make($result)
                ->additional([
                    'message' => __('messages.success.updated', ['record' => 'Dividend']),
                ]);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
