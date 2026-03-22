<?php

namespace App\Domain\Dividend\Contracts\Read;

interface DividendReadRepositoryInterface
{
    public function findAll(): array;
}
