<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Application\Dividend\DTOs\StoreDividendDTO;
use App\Domain\Dividend\Entities\Dividend;

interface StoreDividendInterface
{
    public function handle(StoreDividendDTO $dto): Dividend;
}
