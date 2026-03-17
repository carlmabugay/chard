<?php

namespace App\Domain\Strategy\Contracts\Read;

use App\Domain\Strategy\Entities\Strategy;

interface StrategyReadRepositoryInterface
{
    public function fetchAll(): array;

    public function fetchById(int $id): Strategy;
}
