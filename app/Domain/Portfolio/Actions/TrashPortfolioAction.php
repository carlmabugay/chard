<?php

namespace App\Domain\Portfolio\Actions;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\TrashPortfolioDTO;
use Closure;

final class TrashPortfolioAction
{
    public function __construct(
        protected readonly PortfolioRepositoryInterface $repository,
    ) {}

    public function handle(TrashPortfolioDTO $dto, Closure $next)
    {
        $this->repository->trash($dto);

        return $next($dto);
    }
}
