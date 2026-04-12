<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Application\Strategy\DTOs\StoreStrategyDTO;
use App\Domain\Strategy\Entities\Strategy;

interface StoreStrategyInterface
{
    public function handle(StoreStrategyDTO $dto): Strategy;
}
