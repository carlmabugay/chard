<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Dividend\Entities\Dividend;
use App\Domain\Dividend\Services\DividendService;

class GetDividend
{
    public function __construct(private DividendService $service) {}

    public function handle(int $id): Dividend
    {
        return $this->service->findById($id);
    }
}
