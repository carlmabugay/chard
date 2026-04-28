<?php

namespace App\Domain\Portfolio\Contracts\Persistence\Write;

use App\Application\Portolio\DTOs\PortfolioDTO;

interface PortfolioWriteRepositoryInterface
{
    public function trash(PortfolioDTO $dto): ?bool;

    public function restore(PortfolioDTO $dto): ?bool;

    public function delete(PortfolioDTO $dto): ?bool;
}
