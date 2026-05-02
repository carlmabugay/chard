<?php

namespace App\Domain\TradeLog\Actions;

use App\Domain\TradeLog\Contracts\TradeLogRepositoryInterface;
use App\Domain\TradeLog\DTOs\ListTradeLogsDTO;
use Closure;

final class ListTradeLogsAction
{
    public function __construct(
        protected readonly TradeLogRepositoryInterface $repository
    ) {}

    public function handle(ListTradeLogsDTO $dto, Closure $next)
    {
        $result = $this->repository->findAll($dto);

        return $next($result);
    }
}
