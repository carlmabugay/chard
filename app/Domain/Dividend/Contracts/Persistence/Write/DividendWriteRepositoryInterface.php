<?php

namespace App\Domain\Dividend\Contracts\Persistence\Write;

use App\Application\Dividend\DTOs\DividendDTO;

interface DividendWriteRepositoryInterface
{
    public function delete(DividendDTO $dto): ?bool;
}
