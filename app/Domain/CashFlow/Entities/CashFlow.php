<?php

namespace App\Domain\CashFlow\Entities;

use App\Application\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\Portfolio\Entities\Portfolio;
use App\Enums\CashFlowType;
use App\Models\CashFlow as Model;

readonly class CashFlow
{
    public function __construct(
        private CashFlowType $type,
        private float $amount,
        private ?int $id = null,
        private ?string $created_at = null,
        private ?string $updated_at = null,
        private ?int $portfolio_id = null,
        private ?Portfolio $portfolio = null,
    ) {}

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

    public function portfolioId(): ?int
    {
        return $this->portfolio_id;
    }

    public function portfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public static function fromEloquentModel(Model $model): self
    {
        return new self(
            type: $model->type,
            amount: $model->amount,
            id: $model->id,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
            portfolio_id: $model->portfolio_id,
            portfolio: Portfolio::fromEloquentModel($model->portfolio),
        );
    }

    public static function fromDTO(StoreCashFlowDTO $dto): self
    {
        return new self(
            type: $dto->type(),
            amount: $dto->amount(),
            id: $dto->id(),
            portfolio_id: $dto->portfolioId(),
        );
    }
}
