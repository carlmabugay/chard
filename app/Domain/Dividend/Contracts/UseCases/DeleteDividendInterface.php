<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Application\Dividend\DTOs\DividendDTO;

interface DeleteDividendInterface
{
    public function handle(DividendDTO $dto): ?bool;
}
