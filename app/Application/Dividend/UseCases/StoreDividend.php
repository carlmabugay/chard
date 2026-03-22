<?php

namespace App\Application\Dividend\UseCases;

use App\Application\Dividend\DTOs\StoreDividendDTO;
use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;

class StoreDividend
{
    public function __construct(
        private readonly DividendService $service
    ) {}

    public function handle(StoreDividendDTO $dto): Dividend
    {
        $dividend = Dividend::fromDTO($dto);

        return $this->service->store($dividend);
    }
}
