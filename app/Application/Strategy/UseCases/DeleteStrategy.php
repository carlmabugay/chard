<?php

namespace App\Application\Strategy\UseCases;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\Contracts\UseCases\DeleteStrategyInterface;

class DeleteStrategy implements DeleteStrategyInterface
{
    public function __construct(
        protected readonly StrategyServiceInterface $service
    ) {}

    public function handle(StrategyDTO $dto): ?bool
    {
        return $this->service->delete($dto);
    }
}
