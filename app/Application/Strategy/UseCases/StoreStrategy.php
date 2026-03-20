<?php

namespace App\Application\Strategy\UseCases;

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;

readonly class StoreStrategy
{
    public function __construct(
        private StrategyService $service
    ) {}

    public function handle(StoreStrategyDTO $dto): Strategy
    {
        $portfolio = new Strategy(
            user_id: $dto->userId(),
            name: $dto->name(),
            id: $dto->id(),
        );

        return $this->service->store($portfolio);
    }
}
