<?php

namespace App\Domain\Strategy\Contracts\UseCases;

use App\Application\Strategy\DTOs\StrategyDTO;

interface RestoreStrategyInterface
{
    public function handle(StrategyDTO $strategy): ?bool;
}
