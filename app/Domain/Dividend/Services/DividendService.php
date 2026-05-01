<?php

namespace App\Domain\Dividend\Services;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Entities\Dividend;

class DividendService implements DividendServiceInterface
{
    public function __construct(
        private readonly DividendWriteRepositoryInterface $write_repository,
    ) {}

    public function store(DividendDTO $dto): Dividend
    {
        return $this->write_repository->store($dto);
    }

    public function trash(DividendDTO $dto): ?bool
    {
        return $this->write_repository->trash($dto);
    }

    public function restore(DividendDTO $dto): ?bool
    {
        return $this->write_repository->restore($dto);
    }

    public function delete(DividendDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }
}
