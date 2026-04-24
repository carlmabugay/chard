<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\RestoreStrategyDTO;
use Closure;

final class RestoreStrategyAction
{
    public function __construct(
        protected readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(RestoreStrategyDTO $dto, Closure $next)
    {
        $this->repository->restore($dto);

        return $next($dto);
    }
}
