<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\ListStrategiesDTO;
use Closure;

final class ListStrategiesAction
{
    public function __construct(
        protected readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(ListStrategiesDTO $dto, Closure $next)
    {
        $result = $this->repository->findAll($dto);

        return $next($result);
    }
}
