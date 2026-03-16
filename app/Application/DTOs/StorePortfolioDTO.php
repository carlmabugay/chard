<?php

namespace App\Application\DTOs;

class StorePortfolioDTO
{
    public function __construct(
        public int $user_id,
        public string $name,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            name: $data['name'],
            id: $data['id'] ?? null,
        );
    }
}
