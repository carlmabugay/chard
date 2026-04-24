<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use Closure;

final class CreateNewStrategyAction
{
    public function __construct(
        private readonly StrategyRepositoryInterface $repository
    ) {}

    public function handle(StrategyCreationDTO $dto, Closure $next)
    {
        $this->repository->store($dto);

        return $next($dto);
    }
}
