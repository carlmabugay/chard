<?php

namespace App\Domain\Portfolio\Contracts\Persistence\Write;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioWriteRepositoryInterface
{
    public function store(PortfolioDTO $dto): Portfolio;

    public function trash(PortfolioDTO $dto): ?bool;

    public function restore(PortfolioDTO $dto): ?bool;

    public function delete(PortfolioDTO $dto): ?bool;
}
