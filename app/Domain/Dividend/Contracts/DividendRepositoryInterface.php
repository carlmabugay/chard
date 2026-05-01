<?php

namespace App\Domain\Dividend\Contracts;

use App\Domain\Dividend\DTOs\ListDividendsDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface DividendRepositoryInterface
{
    public function findAll(ListDividendsDTO $dto): LengthAwarePaginator;
}
