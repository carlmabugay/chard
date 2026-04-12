<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\RestoreStrategyInterface;
use App\Models\Strategy as StrategyModel;

class RestoreStrategy implements RestoreStrategyInterface
{
    public function __construct(
        protected StrategyServiceInterface $service
    ) {}

    public function handle(StrategyModel $strategy): ?bool
    {
        return $this->service->restore($strategy);
    }
}
