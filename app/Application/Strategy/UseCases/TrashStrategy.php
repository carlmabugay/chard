<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

class TrashStrategy
{
    public function __construct(
        protected readonly StrategyService $service
    ) {}

    public function handle(StrategyModel $strategy): ?bool
    {
        return $this->service->trash($strategy);
    }
}
