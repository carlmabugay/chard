<?php

namespace App\Domain\Portfolio\Contracts\UseCases;

use App\Application\Portolio\DTOs\StorePortfolioDTO;
use App\Domain\Portfolio\Entities\Portfolio;

interface StorePortfolioInterface
{
    public function handle(StorePortfolioDTO $dto): Portfolio;
}
