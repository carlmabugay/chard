<?php

namespace App\Domain\Strategy\Contracts;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Entities\Strategy;
use App\Models\Strategy as StrategyModel;

interface StrategyServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Strategy;

    public function store(Strategy $strategy): Strategy;

    public function trash(StrategyModel $strategy): ?bool;

    public function restore(StrategyModel $strategy): ?bool;

    public function delete(StrategyModel $strategy): ?bool;
}
