<?php

namespace App\Domain\Portfolio\Contracts\Write;

use App\Domain\Portfolio\Entities\Portfolio;

interface PortfolioWriteRepositoryInterface
{
    public function store(Portfolio $portfolio): Portfolio;

    public function trash(int $id): ?bool;

    public function restore(int $id): ?bool;

    public function delete(int $id): ?bool;
}
