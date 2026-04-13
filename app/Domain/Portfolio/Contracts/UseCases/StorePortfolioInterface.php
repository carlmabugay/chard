<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Domain\Portfolio\Entities\Portfolio;

interface StorePortfolioInterface
{
    public function handle(PortfolioDTO $dto): Portfolio;
}
