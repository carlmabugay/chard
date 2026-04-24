<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\DeleteStrategyDTO;
use Closure;

final class DeleteStrategyAction
{
    public function __construct(
        protected StrategyRepositoryInterface $repository
    ) {}

    public function handle(DeleteStrategyDTO $dto, Closure $next)
    {
        $this->repository->delete($dto);

        return $next($dto);
    }
}
