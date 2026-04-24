<?php

namespace App\Domain\Strategy\Contracts;

use App\Domain\Strategy\DTOs\DeleteStrategyDTO;
use App\Domain\Strategy\DTOs\RestoreStrategyDTO;
use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use App\Domain\Strategy\DTOs\StrategyRevisionDTO;
use App\Domain\Strategy\DTOs\TrashStrategyDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface StrategyRepositoryInterface
{
    public function collect(StrategyCollectionDTO $dto): LengthAwarePaginator;

    public function store(StrategyCreationDTO $dto): void;

    public function revise(StrategyRevisionDTO $dto): void;

    public function trash(TrashStrategyDTO $dto): void;

    public function restore(RestoreStrategyDTO $dto): void;

    public function delete(DeleteStrategyDTO $dto): void;
}
