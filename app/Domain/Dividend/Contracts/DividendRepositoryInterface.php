<?php

namespace App\Domain\Dividend\Contracts;

use App\Domain\Dividend\DTOs\ListDividendsDTO;
use App\Domain\Dividend\DTOs\StoreDividendDTO;
use App\Domain\Dividend\DTOs\TrashDividendDTO;
use App\Domain\Dividend\DTOs\UpdateDividendDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface DividendRepositoryInterface
{
    public function findAll(ListDividendsDTO $dto): LengthAwarePaginator;

    public function store(StoreDividendDTO $dto): void;

    public function update(UpdateDividendDTO $dto): void;

    public function trash(TrashDividendDTO $dto): void;
}
