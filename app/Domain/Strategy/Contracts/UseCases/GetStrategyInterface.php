<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

interface GetStrategyInterface
{
    public function handle(StrategyModel $strategy): Strategy;
}
