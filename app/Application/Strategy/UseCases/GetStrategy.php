<?php

namespace App\Application\Strategy\UseCases;

use App\Domain\Strategy\Contracts\UseCases\GetStrategyInterface;
use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

class GetStrategy implements GetStrategyInterface
{
    public function handle(StrategyModel $strategy): Strategy
    {
        return Strategy::fromEloquentModel($strategy);
    }
}
