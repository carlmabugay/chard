<?php

namespace App\Domain\Portfolio\Actions;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\DeletePortfolioDTO;
use Closure;

final class DeletePortfolioAction
{
    public function __construct(
        protected readonly PortfolioRepositoryInterface $repository
    ) {}

    public function handle(DeletePortfolioDTO $dto, Closure $next)
    {
        $this->repository->delete($dto);

        return $next($dto);
    }
}
