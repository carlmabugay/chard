<?php

namespace App\Domain\Dividend\Contracts\Persistence\Read;

use App\Domain\Dividend\Entities\Dividend;

interface DividendReadRepositoryInterface
{
    public function findById(int $id): Dividend;
}
