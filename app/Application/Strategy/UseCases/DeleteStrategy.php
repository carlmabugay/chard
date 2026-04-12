<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\DeleteStrategyInterface;
use App\Models\Strategy as StrategyModel;

class DeleteStrategy implements DeleteStrategyInterface
{
    public function __construct(
        protected readonly StrategyServiceInterface $service
    ) {}

    public function handle(StrategyModel $strategy): ?bool
    {
        return $this->service->delete($strategy);
    }
}
