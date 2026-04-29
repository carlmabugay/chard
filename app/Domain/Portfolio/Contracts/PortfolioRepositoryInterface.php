<?php

namespace App\Domain\Portfolio\Contracts;

use App\Domain\Portfolio\DTOs\DeletePortfolioDTO;
use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use App\Domain\Portfolio\DTOs\RestorePortfolioDTO;
use App\Domain\Portfolio\DTOs\StorePortfolioDTO;
use App\Domain\Portfolio\DTOs\TrashPortfolioDTO;
use App\Domain\Portfolio\DTOs\UpdatePortfolioDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface PortfolioRepositoryInterface
{
    public function findAll(ListPortfoliosDTO $dto): LengthAwarePaginator;

    public function findById(int $id): ?\stdClass;

    public function store(StorePortfolioDTO $dto): void;

    public function update(UpdatePortfolioDTO $dto): void;

    public function trash(TrashPortfolioDTO $dto): void;

    public function restore(RestorePortfolioDTO $dto): void;

    public function delete(DeletePortfolioDTO $dto): void;
}
