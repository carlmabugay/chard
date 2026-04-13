<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Application\Portolio\DTOs\PortfolioDTO;

interface RestorePortfolioInterface
{
    public function handle(PortfolioDTO $dto): ?bool;
}
