<?php

namespace App\Application\Dividend\UseCases;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Contracts\UseCases\DeleteDividendInterface;

class DeleteDividend implements DeleteDividendInterface
{
    public function __construct(
        protected readonly DividendServiceInterface $service
    ) {}

    public function handle(DividendDTO $dto): ?bool
    {
        return $this->service->delete($dto);
    }
}
