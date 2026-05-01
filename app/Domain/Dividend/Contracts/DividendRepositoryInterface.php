<?php

namespace App\Domain\Dividend\Contracts;

use App\Domain\Dividend\DTOs\DeleteDividendDTO;
use App\Domain\Dividend\DTOs\ListDividendsDTO;
use App\Domain\Dividend\DTOs\RestoreDividendDTO;
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

    public function restore(RestoreDividendDTO $dto): void;

    public function delete(DeleteDividendDTO $dto): void;
}
