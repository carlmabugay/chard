<?php

namespace App\Actions;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use Closure;

final class CreateNewStrategyAction
{
    public function __construct(
        private readonly StrategyServiceInterface $service
    ) {}

    public function handle(object $payload, Closure $next)
    {

        $dto = new StrategyDTO(
            user_id: auth()->user()->id,
            name: $payload->get('name'),
        );

        $this->service->store($dto);

        return $next($payload);
    }
}
