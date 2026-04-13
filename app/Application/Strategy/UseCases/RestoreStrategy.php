<?php

namespace App\Application\Strategy\UseCases;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\RestoreStrategyInterface;

class RestoreStrategy implements RestoreStrategyInterface
{
    public function __construct(
        protected StrategyServiceInterface $service
    ) {}

    public function handle(StrategyDTO $strategy): ?bool
    {
        return $this->service->restore($strategy);
    }
}
