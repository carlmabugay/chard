<?php

namespace App\Application\Strategy\UseCases;

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\StoreStrategyInterface;
use App\Domain\Strategy\Entities\Strategy;

class StoreStrategy implements StoreStrategyInterface
{
    public function __construct(
        private readonly StrategyServiceInterface $service
    ) {}

    public function handle(StoreStrategyDTO $dto): Strategy
    {
        $strategy = Strategy::fromDTO($dto);

        return $this->service->store($strategy);
    }
}
