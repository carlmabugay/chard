<?php

namespace App\Domain\Dividend\Services;

use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Contracts\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;
use App\Models\Dividend as DividendModel;

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

    /*
    * @throws ModelNotFoundException
    */
    public function findById(int $id): Dividend
    {
        return $this->read_repository->findById($id);
    }

    public function store(Dividend $dividend): Dividend
    {
        return $this->write_repository->store($dividend);
    }

    public function trash(DividendModel $dividend): ?bool
    {
        return $this->write_repository->trash($dividend);
    }

    public function restore(DividendModel $dividend): ?bool
    {
        return $this->write_repository->restore($dividend);
    }

    public function delete(DividendModel $dividend): ?bool
    {
        return $this->write_repository->delete($dividend);
    }
}
