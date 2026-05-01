<?php

namespace App\Domain\Dividend\Actions;

use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\DTOs\TrashDividendDTO;
use Closure;

final class TrashDividendAction
{
    public function __construct(
        protected readonly DividendRepositoryInterface $repository,
    ) {}

    public function handle(TrashDividendDTO $dto, Closure $next)
    {
        $this->repository->trash($dto);

        return $next($dto);
    }
}
