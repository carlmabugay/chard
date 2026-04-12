<?php

namespace App\Domain\Dividend\Contracts\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

interface DividendServiceInterface
{
    public function findAll(QueryCriteria $criteria): array;

    public function findById(int $id): Dividend;

    public function store(Dividend $dividend): Dividend;

    public function trash(DividendModel $dividend): ?bool;

    public function restore(DividendModel $dividend): ?bool;

    public function delete(DividendModel $dividend): ?bool;
}
