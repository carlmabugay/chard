<?php

namespace App\Domain\Dividend\Actions;

use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\DTOs\StoreDividendDTO;
use Closure;

final class StoreDividendAction
{
    public function __construct(
        protected readonly DividendRepositoryInterface $repository,
    ) {}

    public function handle(StoreDividendDTO $dto, Closure $next)
    {
        $this->repository->store($dto);

        return $next($dto);
    }
}
