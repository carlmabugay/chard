<?php

namespace App\Domain\Dividend\Contracts\Write;

use App\Domain\Dividend\Entities\Dividend;

interface DividendWriteRepositoryInterface
{
    public function store(Dividend $dividend): Dividend;
}
