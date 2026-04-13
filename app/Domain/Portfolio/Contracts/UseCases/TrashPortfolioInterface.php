<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Application\Portolio\DTOs\PortfolioDTO;

interface TrashPortfolioInterface
{
    public function handle(PortfolioDTO $dto): ?bool;
}
