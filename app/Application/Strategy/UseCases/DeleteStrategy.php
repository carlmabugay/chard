<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Services\StrategyService;

class DeleteStrategy
{
    public function __construct(
        protected readonly StrategyService $service
    ) {}

    public function handle(int $id): ?bool
    {
        return $this->service->delete($id);
    }
}
