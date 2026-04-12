<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Dividend\Contracts\Services\DividendServiceInterface;
use App\Domain\Dividend\Contracts\UseCases\DeleteDividendInterface;
use App\Models\Dividend as DividendModel;

class DeleteDividend implements DeleteDividendInterface
{
    public function __construct(
        protected readonly DividendServiceInterface $service
    ) {}

    public function handle(DividendModel $dividend): ?bool
    {
        return $this->service->delete($dividend);
    }
}
