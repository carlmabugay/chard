<?php

namespace App\Domain\Strategy\Contracts;

use App\Domain\Strategy\DTOs\CreateStrategyDTO;
use App\Domain\Strategy\DTOs\DeleteStrategyDTO;
use App\Domain\Strategy\DTOs\ListStrategiesDTO;
use App\Domain\Strategy\DTOs\RestoreStrategyDTO;
use App\Domain\Strategy\DTOs\TrashStrategyDTO;
use App\Domain\Strategy\DTOs\UpdateStrategyDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface StrategyRepositoryInterface
{
    public function findAll(ListStrategiesDTO $dto): LengthAwarePaginator;

    public function store(CreateStrategyDTO $dto): void;

    public function revise(UpdateStrategyDTO $dto): void;

    public function trash(TrashStrategyDTO $dto): void;

    public function restore(RestoreStrategyDTO $dto): void;

    public function delete(DeleteStrategyDTO $dto): void;
}
