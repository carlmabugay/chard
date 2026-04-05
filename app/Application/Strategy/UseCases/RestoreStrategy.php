<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Services\StrategyService;

class RestoreStrategy
{
    public function __construct(
        protected StrategyService $service
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->restore($id);
    }
}
