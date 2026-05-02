<?php

namespace App\Domain\TradeLog\Actions;

use App\Domain\TradeLog\Contracts\TradeLogRepositoryInterface;
use App\Domain\TradeLog\DTOs\StoreTradeLogDTO;
use Closure;

final class StoreTradeLogAction
{
    public function __construct(
        protected readonly TradeLogRepositoryInterface $repository,
    ) {}

    public function handle(StoreTradeLogDTO $dto, Closure $next)
    {
        $this->repository->store($dto);

        return $next($dto);
    }
}
