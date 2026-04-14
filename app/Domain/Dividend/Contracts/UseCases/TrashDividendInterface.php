<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Application\Dividend\DTOs\DividendDTO;

interface TrashDividendInterface
{
    public function handle(DividendDTO $dto): ?bool;
}
