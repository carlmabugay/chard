<?php

namespace App\Domain\Strategy\Actions;

use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use Closure;

final class CreateNewStrategyAction
{
    public function __construct(
        private readonly StrategyServiceInterface $service
    ) {}

    public function handle(StrategyCreationDTO $dto, Closure $next)
    {
        $this->service->save($dto);

        return $next($dto);
    }
}
