<?php

namespace App\Http\Controllers\v1\CashFlow;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\Contracts\UseCases\StoreCashFlowInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlow\CreateCashFlowRequest;
use App\Http\Resources\CashFlow\CashFlowResource;
use App\Models\CashFlow;
use App\Models\Portfolio;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class StoreController extends Controller
{
    public function __invoke(CreateCashFlowRequest $request, StoreCashFlowInterface $use_case): CashFlowResource|JsonResponse
    {
        try {

            // TODO: Use service here.
            $portfolio = Portfolio::find($request->validated('portfolio_id'));

            Gate::authorize('store', [CashFlow::class, $portfolio]);

            $dto = StoreCashFlowDTO::fromRequest($request->validated());

            $result = $use_case->handle($dto);

            return new CashFlowResource($result)
                ->additional([
                    'message' => __('messages.success.stored', ['record' => 'Cash flow']),
                ])
                ->response()
                ->setStatusCode(201);

        } catch (AuthorizationException) {

            return $this->unauthorizedResponse();

        } catch (Throwable $error) {

            return $this->errorResponse($error->getMessage());

        }
    }
}
