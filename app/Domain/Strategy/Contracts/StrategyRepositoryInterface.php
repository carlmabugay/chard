<?php

namespace App\Domain\Strategy\Contracts;

use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface StrategyRepositoryInterface
{
    public function collect(StrategyCollectionDTO $dto): LengthAwarePaginator;

    public function store(StrategyCreationDTO $dto): void;
}
