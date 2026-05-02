<?php

namespace App\Domain\TradeLog\Contracts\Persistence\Read;

use App\Domain\TradeLog\Entities\TradeLog;

interface TradeLogReadRepositoryInterface
{
    public function findById(int $id): TradeLog;
}
