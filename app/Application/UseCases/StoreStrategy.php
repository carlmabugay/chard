<?php

namespace App\Application\UseCases;

use App\Application\DTOs\StoreStrategyDTO;
use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;

class StoreStrategy
{
    public function __construct(
        private readonly StrategyService $service
    ) {}

    public function handle(StoreStrategyDTO $dto): Strategy
    {
        $portfolio = new Strategy(
            user_id: $dto->user_id,
            name: $dto->name,
            id: $dto->id,
        );

        return $this->service->store($portfolio);
    }
}
