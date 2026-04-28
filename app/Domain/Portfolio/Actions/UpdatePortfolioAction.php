<?php

namespace App\Domain\Portfolio\Actions;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\UpdatePortfolioDTO;
use Closure;

final class UpdatePortfolioAction
{
    public function __construct(
        protected readonly PortfolioRepositoryInterface $repository,
    ) {}

    public function handle(UpdatePortfolioDTO $dto, Closure $next)
    {

        $this->repository->update($dto);

        return $next($dto);
    }
}
