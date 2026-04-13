<?php

namespace App\Domain\Strategy\Contracts\Persistence\Write;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Entities\Strategy;

interface StrategyWriteRepositoryInterface
{
    public function store(StrategyDTO $dto): Strategy;

    public function trash(StrategyDTO $dto): ?bool;

    public function restore(StrategyDTO $dto): ?bool;

    public function delete(StrategyDTO $dto): ?bool;
}
