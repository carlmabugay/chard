<?php

namespace App\Domain\Dividend\Contracts\Services;

use App\Application\Dividend\DTOs\DividendDTO;

interface DividendServiceInterface
{
    public function delete(DividendDTO $dto): ?bool;
}
