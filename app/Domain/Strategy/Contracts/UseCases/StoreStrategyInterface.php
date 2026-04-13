<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Entities\Strategy;

interface StoreStrategyInterface
{
    public function handle(StrategyDTO $dto): Strategy;
}
