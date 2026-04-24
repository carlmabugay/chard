<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use Closure;

final class CollectStrategiesAction
{
    public function __construct(
        private readonly StrategyServiceInterface $service
    ) {}

    public function handle(StrategyCollectionDTO $dto, Closure $next)
    {
        $result = $this->service->collect($dto);

        return $next($result);
    }
}
