<?php

namespace App\Domain\Strategy\Contracts\Services;

use App\Application\Strategy\DTOs\StrategyDTO;

interface StrategyServiceInterface
{
    public function restore(StrategyDTO $dto): ?bool;

    public function delete(StrategyDTO $dto): ?bool;
}
