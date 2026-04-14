<?php

namespace App\Domain\TradeLog\Entities;

use App\Application\TradeLog\DTOs\TradeLogDTO;
use App\Domain\Portfolio\Entities\Portfolio;
use Illuminate\Database\Eloquent\Model;

readonly class TradeLog
{
    public function __construct(
        private int $portfolio_id,
        private string $symbol,
        private string $type,
        private float $price,
        private int $shares,
        private float $fees,
        private ?int $id = null,
        private ?string $created_at = null,
        private ?string $updated_at = null,
        private ?Portfolio $portfolio = null,
    ) {}

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function shares(): int
    {
        return $this->shares;
    }

    public function fees(): float
    {
        return $this->fees;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function createdAt(): ?string
    {
        return $this->created_at;
    }

    public function updatedAt(): ?string
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
            portfolio_id: $model->portfolio_id,
            symbol: $model->symbol,
            type: $model->type,
            price: $model->price,
            shares: $model->shares,
            fees: $model->fees,
            id: $model->id,
            created_at: $model->created_at,
            updated_at: $model->updated_at,
            portfolio: Portfolio::fromEloquentModel($model->portfolio),
        );
    }

    public static function fromDTO(TradeLogDTO $dto): self
    {
        return new self(
            portfolio_id: $dto->portfolioId(),
            symbol: $dto->symbol(),
            type: $dto->type(),
            price: $dto->price(),
            shares: $dto->shares(),
            fees: $dto->fees(),
            id: $dto->id(),
        );
    }
}
