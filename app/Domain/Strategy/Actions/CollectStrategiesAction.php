<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use Closure;

final class CollectStrategiesAction
{
    public function __construct(
        private readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(StrategyCollectionDTO $dto, Closure $next)
    {
        $result = $this->repository->collect($dto);

        return $next($result);
    }
}
