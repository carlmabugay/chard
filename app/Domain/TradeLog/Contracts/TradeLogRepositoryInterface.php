<?php

namespace App\Domain\TradeLog\Contracts;

use App\Domain\TradeLog\DTOs\ListTradeLogsDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface TradeLogRepositoryInterface
{
    public function findAll(ListTradeLogsDTO $dto): LengthAwarePaginator;
}
