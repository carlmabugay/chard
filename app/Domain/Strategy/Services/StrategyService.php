<?php

namespace App\Domain\Strategy\Services;

use App\Domain\Strategy\Contracts\Read\StrategyReadRepositoryInterface;

class StrategyService
{
    public function __construct(
        private readonly StrategyReadRepositoryInterface $read_repository
    ) {}

    public function fetchAll(): array
    {
        return $this->read_repository->fetchAll();
    }
}
