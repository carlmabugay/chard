<?php

namespace App\Application\Strategy\DTOs;

readonly class StoreStrategyDTO
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

    public static function fromRequest(array $request): self
    {
        return new self(
            user_id: $request['user_id'],
            name: $request['name'],
            id: $request['id'] ?? null,
        );
    }
}
