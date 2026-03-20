<?php

namespace App\Domain\CashFlow\Entities;

use App\Models\CashFlow as Model;

class CashFlow
{
    public function __construct(
        private readonly int $portfolio_id,
        private readonly string $type,
        private readonly float $amount,
        private readonly ?string $created_at = null,
        private readonly ?string $updated_at = null,
    ) {}

    public function portfolioId(): int
    {
        return $this->portfolio_id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function createdAt(): string
    {
        return $this->created_at;
    }

    public function updatedAt(): string
    {
        return $this->updated_at;
    }

    public static function fromEloquentModel(Model $model): self
    {
        return new self(
            portfolio_id: $model->portfolio_id,
            type: $model->type,
            amount: $model->amount,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
        );
    }
}
