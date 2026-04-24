<?php

namespace App\Domain\Strategy\DTOs;

final class StrategyRevisionDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
