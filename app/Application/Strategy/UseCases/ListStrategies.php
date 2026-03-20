<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Services\StrategyService;

readonly class ListStrategies
{
    public function __construct(
        private StrategyService $service
    ) {}

    public function handle(): array
    {
        return $this->service->fetchAll();
    }
}
