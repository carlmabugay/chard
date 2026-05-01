<?php

namespace App\Domain\Dividend\Contracts;

use App\Domain\Dividend\DTOs\ListDividendsDTO;
use App\Domain\Dividend\DTOs\StoreDividendDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface DividendRepositoryInterface
{
    public function findAll(ListDividendsDTO $dto): LengthAwarePaginator;

    public function store(StoreDividendDTO $dto): void;
}
