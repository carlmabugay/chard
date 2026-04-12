<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Models\Dividend as DividendModel;

interface DeleteDividendInterface
{
    public function handle(DividendModel $dividend): ?bool;
}
