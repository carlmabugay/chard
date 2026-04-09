<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

class GetDividend
{
    public function handle(DividendModel $dividend): Dividend
    {
        return Dividend::fromEloquentModel($dividend);
    }
}
