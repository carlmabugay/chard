<?php

namespace App\Domain\Dividend\Contracts\UseCases;

use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

interface GetDividendInterface
{
    public function handle(DividendModel $dividend): Dividend;
}
