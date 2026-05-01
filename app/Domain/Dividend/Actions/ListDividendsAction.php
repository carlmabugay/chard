<?php

namespace App\Domain\Dividend\Actions;

use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\DTOs\ListDividendsDTO;
use Closure;

final class ListDividendsAction
{
    public function __construct(
        protected readonly DividendRepositoryInterface $repository,
    ) {}

    public function handle(ListDividendsDTO $dto, Closure $next)
    {
        $result = $this->repository->findAll($dto);

        return $next($result);

    }
}
