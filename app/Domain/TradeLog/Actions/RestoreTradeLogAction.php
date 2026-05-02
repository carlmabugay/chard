<?php

namespace App\Domain\TradeLog\Actions;

use App\Domain\TradeLog\Contracts\TradeLogRepositoryInterface;
use App\Domain\TradeLog\DTOs\RestoreTradeLogDTO;
use Closure;

final class RestoreTradeLogAction
{
    public function __construct(
        protected readonly TradeLogRepositoryInterface $repository,
    ) {}

    public function handle(RestoreTradeLogDTO $dto, Closure $next)
    {

        $this->repository->restore($dto);

        return $next($dto);
    }
}
