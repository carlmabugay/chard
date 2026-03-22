<?php

namespace App\Domain\Dividend\Services;

use App\Domain\Dividend\Contracts\Read\DividendReadRepositoryInterface;

class DividendService
{
    public function __construct(
        private readonly DividendReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(): array
    {
        return $this->read_repository->findAll();
    }
}
