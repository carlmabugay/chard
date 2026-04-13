<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Application\Strategy\DTOs\StrategyDTO;

interface TrashStrategyInterface
{
    public function handle(StrategyDTO $dto): ?bool;
}
