<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

class GetStrategy
{
    public function handle(StrategyModel $strategy): Strategy
    {
        return Strategy::fromEloquentModel($strategy);
    }
}
