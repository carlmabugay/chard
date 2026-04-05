<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Dividend\Services\DividendService;

class RestoreDividend
{
    public function __construct(
        protected readonly DividendService $service
    ) {}

    public function handle(int $id): ?bool
    {

        return $this->service->restore($id);
    }
}
