<?php

namespace App\Application\Dividend\UseCases;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Contracts\UseCases\StoreDividendInterface;
use App\Domain\Dividend\Entities\Dividend;

class StoreDividend implements StoreDividendInterface
{
    public function __construct(
        private readonly DividendServiceInterface $service
    ) {}

    public function handle(DividendDTO $dto): Dividend
    {
        return $this->service->store($dto);
    }
}
