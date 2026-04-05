<?php

namespace App\Domain\Strategy\Contracts\Write;

use App\Domain\Strategy\Entities\Strategy;

interface StrategyWriteRepositoryInterface
{
    public function store(Strategy $strategy): Strategy;

    public function trash(int $id): ?bool;

    public function restore(int $id): ?bool;

    public function delete(int $id): ?bool;
}
