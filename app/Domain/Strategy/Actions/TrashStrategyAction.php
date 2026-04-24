<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\TrashStrategyDTO;
use Closure;

final class TrashStrategyAction
{
    public function __construct(
        protected readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(TrashStrategyDTO $dto, Closure $next)
    {
        $this->repository->trash($dto);

        return $next($dto);
    }
}
