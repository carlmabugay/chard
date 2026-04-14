<?php

namespace App\Domain\TradeLog\Services;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\TradeLog\Contracts\Persistence\Read\TradeLogReadRepositoryInterface;
use App\Domain\TradeLog\Contracts\Persistence\Write\TradeLogWriteRepositoryInterface;
use App\Domain\TradeLog\Contracts\Services\TradeLogServiceInterface;
use App\Domain\TradeLog\Entities\TradeLog;

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
