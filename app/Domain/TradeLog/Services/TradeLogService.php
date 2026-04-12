<?php

namespace App\Domain\TradeLog\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Persistence\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Contracts\Persistence\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Entities\TradeLog;
use App\Models\TradeLog as TradeLogModel;

class TradeLogService implements TradeLogServiceInterface
{
    public function __construct(
        private readonly TradeLogWriteRepositoryInterface $write_repository,
        private readonly TradeLogReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }

    /*
     * throws ModelNotFoundException
     */
    public function findById(int $id): TradeLog
    {
        return $this->read_repository->findById($id);
    }

    public function store(TradeLog $tradeLog): TradeLog
    {
        return $this->write_repository->store($tradeLog);
    }

    public function trash(TradeLogModel $trade_log): ?bool
    {
        return $this->write_repository->trash($trade_log);
    }

    public function restore(TradeLogModel $trade_log): ?bool
    {
        return $this->write_repository->restore($trade_log);
    }

    public function delete(TradeLogModel $trade_log): ?bool
    {
        return $this->write_repository->delete($trade_log);
    }
}
