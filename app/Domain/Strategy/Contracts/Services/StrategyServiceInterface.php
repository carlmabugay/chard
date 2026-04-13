<?php

namespace App\Domain\Strategy\Contracts\Services;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Entities\Strategy;

interface StrategyServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Strategy;

    public function store(StrategyDTO $dto): Strategy;

    public function trash(StrategyDTO $dto): ?bool;

    public function restore(StrategyDTO $dto): ?bool;

    public function delete(StrategyDTO $dto): ?bool;
}
