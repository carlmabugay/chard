<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\TrashStrategyInterface;
use App\Models\Strategy as StrategyModel;

class TrashStrategy implements TrashStrategyInterface
{
    public function __construct(
        protected readonly StrategyServiceInterface $service
    ) {}

    public function handle(StrategyModel $strategy): ?bool
    {
        return $this->service->trash($strategy);
    }
}
