<?php

namespace App\Domain\Strategy\Services;

use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Entities\Strategy;

class StrategyService
{
    public function __construct(
        private readonly StrategyReadRepositoryInterface $read_repository
    ) {}

    public function fetchAll(): array
    {
        return $this->read_repository->fetchAll();
    }

    public function fetchById(int $id): Strategy
    {
        return $this->read_repository->fetchById($id);
    }
}
