<?php

namespace App\Domain\Dividend\Contracts\Services;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Entities\Dividend;

interface DividendServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Dividend;

    public function store(DividendDTO $dto): Dividend;

    public function trash(DividendDTO $dto): ?bool;

    public function restore(DividendDTO $dto): ?bool;

    public function delete(DividendDTO $dto): ?bool;
}
