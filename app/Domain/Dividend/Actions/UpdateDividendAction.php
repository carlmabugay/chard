<?php

namespace App\Domain\Dividend\Actions;

use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\DTOs\UpdateDividendDTO;
use Closure;

final class UpdateDividendAction
{
    public function __construct(
        protected readonly DividendRepositoryInterface $repository,
    ) {}

    public function handle(UpdateDividendDTO $dto, Closure $next)
    {
        $this->repository->update($dto);

        return $next($dto);
    }
}
