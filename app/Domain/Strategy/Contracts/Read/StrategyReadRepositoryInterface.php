<?php

namespace App\Domain\Strategy\Contracts\Read;

interface StrategyReadRepositoryInterface
{
    public function fetchAll(): array;
}
