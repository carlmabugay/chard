<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Models\Dividend as DividendModel;

interface TrashDividendInterface
{
    public function handle(DividendModel $dividend): ?bool;
}
