<?php

namespace App\Application\UseCases;

use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;

class GetStrategy
{
    public function __construct(
        private readonly StrategyService $service
    ) {}

    public function handle(int $id): Strategy
    {
        return $this->service->fetchById($id);
    }
}
