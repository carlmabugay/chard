<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Application\Portolio\DTOs\PortfolioDTO;

interface DeletePortfolioInterface
{
    public function handle(PortfolioDTO $dto): ?bool;
}
