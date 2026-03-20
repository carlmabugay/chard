<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Entities\Strategy;
use App\Domain\Strategy\Services\StrategyService;

readonly class GetStrategy
{
    public function __construct(
        private StrategyService $service
    ) {}

    public function handle(int $id): Strategy
    {
        return $this->service->fetchById($id);
    }
}
