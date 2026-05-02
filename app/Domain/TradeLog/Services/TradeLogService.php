<?php

namespace App\Domain\TradeLog\Services;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\TradeLog\Contracts\Persistence\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Entities\TradeLog;

class TradeLogService implements TradeLogServiceInterface
{
    public function __construct(
        private readonly TradeLogWriteRepositoryInterface $write_repository,
    ) {}

    public function store(TradeLogDTO $dto): TradeLog
    {
        return $this->write_repository->store($dto);
    }

    public function trash(TradeLogDTO $dto): ?bool
    {
        return $this->write_repository->trash($dto);
    }

    public function restore(TradeLogDTO $dto): ?bool
    {
        return $this->write_repository->restore($dto);
    }

    public function delete(TradeLogDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }
}
