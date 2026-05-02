<?php

namespace App\Domain\TradeLog\Contracts;

use App\Domain\TradeLog\DTOs\DeleteTradeLogDTO;
use App\Domain\TradeLog\DTOs\ListTradeLogsDTO;
use App\Domain\TradeLog\DTOs\RestoreTradeLogDTO;
use App\Domain\TradeLog\DTOs\StoreTradeLogDTO;
use App\Domain\TradeLog\DTOs\TrashTradeLogDTO;
use App\Domain\TradeLog\DTOs\UpdateTradeLogDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface TradeLogRepositoryInterface
{
    public function findAll(ListTradeLogsDTO $dto): LengthAwarePaginator;

    public function store(StoreTradeLogDTO $dto): void;

    public function update(UpdateTradeLogDTO $dto): void;

    public function trash(TrashTradeLogDTO $dto): void;

    public function restore(RestoreTradeLogDTO $dto): void;

    public function delete(DeleteTradeLogDTO $dto): void;
}
