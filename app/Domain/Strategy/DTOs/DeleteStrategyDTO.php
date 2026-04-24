<?php

namespace App\Domain\Strategy\DTOs;

final class DeleteStrategyDTO
{
    public function __construct(
        public int $id,
    ) {}
}
