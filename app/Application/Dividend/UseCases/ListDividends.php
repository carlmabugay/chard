<?php

namespace App\Application\Dividend\UseCases;

use App\Domain\Dividend\Services\DividendService;

class ListDividends
{
    public function __construct(private readonly DividendService $service) {}

    public function handle(): array
    {
        return $this->service->findAll();
    }
}
