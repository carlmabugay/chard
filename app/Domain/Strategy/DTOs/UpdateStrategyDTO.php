<?php

namespace App\Domain\Strategy\DTOs;

final class UpdateStrategyDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
