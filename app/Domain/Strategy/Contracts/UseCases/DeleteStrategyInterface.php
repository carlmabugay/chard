<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Application\Strategy\DTOs\StrategyDTO;

interface DeleteStrategyInterface
{
    public function handle(StrategyDTO $dto): ?bool;
}
