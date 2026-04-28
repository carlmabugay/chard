<?php

namespace App\Domain\Portfolio\Actions;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\RestorePortfolioDTO;
use Closure;

final class RestorePortfolioAction
{
    public function __construct(
        protected readonly PortfolioRepositoryInterface $repository,
    ) {}

    public function handle(RestorePortfolioDTO $dto, Closure $next)
    {
        $this->repository->restore($dto);

        return $next($dto);
    }
}
