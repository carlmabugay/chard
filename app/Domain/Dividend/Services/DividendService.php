<?php

namespace App\Domain\Dividend\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;

class DividendService
{
    public function __construct(
        private readonly DividendWriteRepositoryInterface $write_repository,
        private readonly DividendReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }

    public function findById(int $id): Dividend
    {
        return $this->read_repository->findById($id);
    }

    public function store(Dividend $dividend): Dividend
    {
        return $this->write_repository->store($dividend);
    }

    public function trash(int $id): ?bool
    {
        return $this->write_repository->trash($id);
    }

    /*
     * @throws ModelNotFoundException
     */
    public function restore(int $id): ?bool
    {
        return $this->write_repository->restore($id);
    }
}
