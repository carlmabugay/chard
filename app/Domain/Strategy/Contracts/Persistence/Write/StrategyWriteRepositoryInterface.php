<?php

namespace App\Domain\Strategy\Contracts\Persistence\Write;

use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

interface StrategyWriteRepositoryInterface
{
    public function store(Strategy $strategy): Strategy;

    public function trash(StrategyModel $strategy): ?bool;

    public function restore(StrategyModel $strategy): ?bool;

    public function delete(StrategyModel $strategy): ?bool;
}
