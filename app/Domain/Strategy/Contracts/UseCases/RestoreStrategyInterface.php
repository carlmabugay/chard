<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Models\Strategy as StrategyModel;

interface RestoreStrategyInterface
{
    public function handle(StrategyModel $strategy): ?bool;
}
