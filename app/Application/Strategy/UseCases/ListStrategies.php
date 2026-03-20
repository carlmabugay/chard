<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Services\StrategyService;

class ListStrategies
{
    public function __construct(
        private readonly StrategyService $service
    ) {}

    public function handle(): array
    {
        return $this->service->fetchAll();
    }
}
