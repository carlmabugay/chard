<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Dividend\Services\DividendService;
use App\Models\Dividend as DividendModel;

class RestoreDividend
{
    public function __construct(
        protected readonly DividendService $service
    ) {}

    public function handle(DividendModel $dividend): ?bool
    {

        return $this->service->restore($dividend);
    }
}
