<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Services\StrategyService;
use App\Models\Strategy as StrategyModel;

class RestoreStrategy
{
    public function __construct(
        protected StrategyService $service
    ) {}

    public function handle(StrategyModel $strategy): ?bool
    {
        return $this->service->restore($strategy);
    }
}
