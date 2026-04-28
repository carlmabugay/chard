<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\UpdateStrategyDTO;
use Closure;

final class UpdateStrategyAction
{
    public function __construct(
        protected readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(UpdateStrategyDTO $dto, Closure $next)
    {
        $this->repository->update($dto);

        return $next($dto);
    }
}
