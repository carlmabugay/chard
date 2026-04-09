<?php

namespace App\Application\Portolio\DTOs;

readonly class StorePortfolioDTO
{
    public function __construct(
        private int $user_id,
        private string $name,
        private ?int $id = null,
    ) {}

    public function userId(): int
    {
        return $this->user_id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function id(): ?int
    {
        return $this->id;
    }
}
