<?php

namespace App\Domain\Portfolio\Entities;

readonly class Portfolio
{
    public function __construct(
        private int $user_id,
        private string $name,
        private ?int $id = null,
        private ?string $created_at = null,
        private ?string $updated_at = null,
    ) {}

    public function userId(): int
    {
        return $this->user_id;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): ?string
    {
        return $this->created_at;
    }

    public function updatedAt(): ?string
    {
        return $this->updated_at;
    }
}
