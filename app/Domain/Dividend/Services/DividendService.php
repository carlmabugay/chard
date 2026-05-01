<?php

namespace App\Domain\Dividend\Services;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\Persistence\Write\DividendWriteRepositoryInterface;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;

class DividendService implements DividendServiceInterface
{
    public function __construct(
        private readonly DividendWriteRepositoryInterface $write_repository,
    ) {}

    public function delete(DividendDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }
}
