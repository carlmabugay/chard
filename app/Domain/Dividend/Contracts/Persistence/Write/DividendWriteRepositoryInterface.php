<?php

namespace App\Domain\Dividend\Contracts\Persistence\Write;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Entities\Dividend;

interface DividendWriteRepositoryInterface
{
    public function store(DividendDTO $dto): Dividend;

    public function trash(DividendDTO $dto): ?bool;

    public function restore(DividendDTO $dto): ?bool;

    public function delete(DividendDTO $dto): ?bool;
}
