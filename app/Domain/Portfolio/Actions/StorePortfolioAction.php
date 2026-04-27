<?php

namespace App\Domain\Portfolio\Actions;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\StorePortfolioDTO;
use Closure;

final class StorePortfolioAction
{
    public function __construct(
        protected readonly PortfolioRepositoryInterface $repository
    ) {}

    public function handle(StorePortfolioDTO $dto, Closure $next)
    {

        $this->repository->store($dto);

        return $next($dto);

    }
}
