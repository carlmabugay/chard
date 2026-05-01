<?php

namespace App\Domain\Dividend\Contracts\Services;

use App\Application\Dividend\DTOs\DividendDTO;

interface DividendServiceInterface
{
    public function restore(DividendDTO $dto): ?bool;

    public function delete(DividendDTO $dto): ?bool;
}
