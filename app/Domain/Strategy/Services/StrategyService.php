<?php

namespace App\Domain\Strategy\Services;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\Persistence\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;

class StrategyService implements StrategyServiceInterface
{
    public function __construct(
        private readonly StrategyWriteRepositoryInterface $write_repository,
    ) {}

    public function restore(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->restore($dto);
    }

    public function delete(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }
}
