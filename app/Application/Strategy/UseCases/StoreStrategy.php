<?php

namespace App\Application\Strategy\UseCases;

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;

class StoreStrategy
{
    public function __construct(
        private readonly StrategyService $service
    ) {}

    public function handle(StoreStrategyDTO $dto): Strategy
    {
        $strategy = Strategy::fromDTO($dto);

        return $this->service->store($strategy);
    }
}
