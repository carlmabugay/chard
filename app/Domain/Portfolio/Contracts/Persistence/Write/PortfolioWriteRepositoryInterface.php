<?php

namespace App\Domain\Portfolio\Contracts\Persistence\Write;

use App\Domain\Portfolio\Entities\Portfolio;
use App\Models\Portfolio as PortfolioModel;

interface PortfolioWriteRepositoryInterface
{
    public function store(Portfolio $portfolio): Portfolio;

    public function trash(PortfolioModel $portfolio): ?bool;

    public function restore(PortfolioModel $portfolio): ?bool;

    public function delete(PortfolioModel $portfolio): ?bool;
}
