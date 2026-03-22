<?php

namespace App\Domain\Dividend\Services;

use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;
use App\Domain\Dividend\Entities\Dividend;

class DividendService
{
    public function __construct(
        private readonly DividendReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(): array
    {
        return $this->read_repository->findAll();
    }

    public function findById(int $id): Dividend
    {
        return $this->read_repository->findById($id);
    }
}
