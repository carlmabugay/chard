<?php

namespace App\Domain\CashFlow\Entities;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Enums\CashFlowType;
use App\Models\CashFlow as Model;

readonly class CashFlow
{
    public function __construct(
        private int $portfolio_id,
        private CashFlowType $type,
        private float $amount,
        private ?int $id = null,
        private ?string $created_at = null,
        private ?string $updated_at = null,
    ) {}

    public function portfolioId(): int
    {
        return $this->portfolio_id;
    }

    public function type(): CashFlowType
    {
        return $this->type;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function id(): ?int
    {
        return $this->id;
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
            id: $model->id,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
        );
    }

    public static function fromDTO(StoreCashFlowDTO $dto): self
    {
        return new self(
            portfolio_id: $dto->portfolioId(),
            type: $dto->type(),
            amount: $dto->amount(),
            id: $dto->id(),
        );
    }
}
