<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Models\Dividend as DividendModel;

interface RestoreDividendInterface
{
    public function handle(DividendModel $dividend): ?bool;
}
