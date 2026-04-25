<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\CreateStrategyDTO;
use Closure;

final class CreateStrategyAction
{
    public function __construct(
        protected readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(CreateStrategyDTO $dto, Closure $next)
    {
        $this->repository->store($dto);

        return $next($dto);
    }
}
