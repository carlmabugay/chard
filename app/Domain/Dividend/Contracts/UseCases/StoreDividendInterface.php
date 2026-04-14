<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Entities\Dividend;

interface StoreDividendInterface
{
    public function handle(DividendDTO $dto): Dividend;
}
