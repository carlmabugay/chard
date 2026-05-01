<?php

namespace App\Domain\Dividend\Actions;

use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\DTOs\DeleteDividendDTO;
use Closure;

final class DeleteDividendAction
{
    public function __construct(
        protected readonly DividendRepositoryInterface $repository,
    ) {}

    public function handle(DeleteDividendDTO $dto, Closure $next)
    {
        $this->repository->delete($dto);

        return $next($dto);
    }
}
