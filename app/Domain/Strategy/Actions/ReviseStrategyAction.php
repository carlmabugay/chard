<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\StrategyRevisionDTO;
use Closure;

final class ReviseStrategyAction
{
    public function __construct(
        protected readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(StrategyRevisionDTO $dto, Closure $next)
    {
        $this->repository->revise($dto);

        return $next($dto);
    }
}
