<?php

namespace App\Application\Strategy\UseCases;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\StoreStrategyInterface;
use App\Domain\Strategy\Entities\Strategy;

class StoreStrategy implements StoreStrategyInterface
{
    public function __construct(
        private readonly StrategyServiceInterface $service
    ) {}

    public function handle(StrategyDTO $dto): Strategy
    {
        return $this->service->store($dto);
    }
}
