<?php

namespace App\Domain\Dividend\Contracts\Write;

use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

interface DividendWriteRepositoryInterface
{
    public function store(Dividend $dividend): Dividend;

    public function trash(DividendModel $dividend): ?bool;

    public function restore(DividendModel $dividend): ?bool;

    public function delete(DividendModel $dividend): ?bool;
}
