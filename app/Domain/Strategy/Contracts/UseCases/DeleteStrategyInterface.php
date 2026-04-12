<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Models\Strategy as StrategyModel;

interface DeleteStrategyInterface
{
    public function handle(StrategyModel $strategy): ?bool;
}
