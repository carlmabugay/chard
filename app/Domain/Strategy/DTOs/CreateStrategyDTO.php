<?php

namespace App\Domain\Strategy\DTOs;

final class CreateStrategyDTO
{
    public function __construct(
        public int $user_id,
        public string $name,
    ) {}
}
