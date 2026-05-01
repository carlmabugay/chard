<?php

namespace App\Domain\Dividend\Actions;

use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\DTOs\RestoreDividendDTO;
use Closure;

final class RestoreDividendAction
{
    public function __construct(
        protected readonly DividendRepositoryInterface $repository,
    ) {}

    public function handle(RestoreDividendDTO $dto, Closure $next)
    {
        $this->repository->restore($dto);

        return $next($dto);
    }
}
