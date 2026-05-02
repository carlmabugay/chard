<?php

namespace App\Domain\TradeLog\Actions;

use App\Domain\TradeLog\Contracts\TradeLogRepositoryInterface;
use App\Domain\TradeLog\DTOs\DeleteTradeLogDTO;
use Closure;

final class DeleteTradeLogAction
{
    public function __construct(
        protected readonly TradeLogRepositoryInterface $repository,
    ) {}

    public function handle(DeleteTradeLogDTO $dto, Closure $next)
    {
        $this->repository->delete($dto);

        return $next($dto);
    }
}
