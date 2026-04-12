<?php

namespace App\Application\Dividend\UseCases;

use App\Application\Dividend\DTOs\StoreDividendDTO;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Contracts\UseCases\StoreDividendInterface;
use App\Domain\Dividend\Entities\Dividend;

class StoreDividend implements StoreDividendInterface
{
    public function __construct(
        private readonly DividendServiceInterface $service
    ) {}

    public function handle(StoreDividendDTO $dto): Dividend
    {
        $dividend = Dividend::fromDTO($dto);

        return $this->service->store($dividend);
    }
}
