<?php

namespace App\Domain\TradeLog\Contracts;

use App\Domain\TradeLog\DTOs\ListTradeLogsDTO;
use App\Domain\TradeLog\DTOs\StoreTradeLogDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface TradeLogRepositoryInterface
{
    public function findAll(ListTradeLogsDTO $dto): LengthAwarePaginator;

    public function store(StoreTradeLogDTO $dto): void;
}
