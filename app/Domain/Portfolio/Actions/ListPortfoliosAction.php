<?php

namespace App\Domain\Portfolio\Actions;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use Closure;

final class ListPortfoliosAction
{
    public function __construct(
        protected readonly PortfolioRepositoryInterface $repository
    ) {}

    public function handle(ListPortfoliosDTO $dto, Closure $next)
    {
        $result = $this->repository->findAll($dto);

        return $next($result);
    }
}
