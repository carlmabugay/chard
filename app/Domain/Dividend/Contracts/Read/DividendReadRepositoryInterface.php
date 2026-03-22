<?php

namespace App\Domain\Dividend\Contracts\Read;

use App\Domain\Dividend\Entities\Dividend;

interface DividendReadRepositoryInterface
{
    public function findAll(): array;

    public function findById(int $id): Dividend;
}
