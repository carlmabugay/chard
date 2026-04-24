<?php

namespace App\Domain\Strategy\DTOs;

final class StrategyCreationDTO
{
    public function __construct(
        public int $user_id,
        public string $name,
    ) {}
}
