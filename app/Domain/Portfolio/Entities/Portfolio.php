<?php

namespace App\Domain\Portfolio\Entities;

use App\Application\Portolio\DTOs\PortfolioDTO;
use App\Models\Portfolio as Model;

class Portfolio
{
    public function __construct(
        private readonly int $user_id,
        private readonly string $name,
        private readonly ?int $id = null,
        private readonly ?string $created_at = null,
        private readonly ?string $updated_at = null,
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

    public static function fromEloquentModel(Model $model): self
    {
        return new self(
            user_id: $model->user_id,
            name: $model->name,
            id: $model->id,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
        );
    }

    public static function fromDTO(PortfolioDTO $dto): self
    {
        return new self(
            user_id: $dto->userId(),
            name: $dto->name(),
            id: $dto->id(),
        );
    }

    public function toEloquentModel(): Model
    {
        $portfolio = new Model;
        $portfolio->user_id = self::userId();
        $portfolio->name = self::name();
        $portfolio->id = self::id();

        return $portfolio;
    }
}
