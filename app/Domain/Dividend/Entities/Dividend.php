<?php

namespace App\Domain\Dividend\Entities;

use App\Application\Dividend\DTOs\DividendDTO;
use App\Domain\Portfolio\Entities\Portfolio;
use Illuminate\Database\Eloquent\Model;

readonly class Dividend
{
    public function __construct(
        private int $portfolio_id,
        private string $symbol,
        private float $amount,
        private ?int $id = null,
        private ?string $recorded_at = null,
        private ?Portfolio $portfolio = null,
    ) {}

    public function portfolioId(): int
    {
        return $this->portfolio_id;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function recordedAt(): ?string
    {
        return $this->recorded_at;
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
            amount: $model->amount,
            id: $model->id,
            recorded_at: $model->recorded_at,
            portfolio: Portfolio::fromEloquentModel($model->portfolio),
        );
    }

    public static function fromDTO(DividendDTO $dto): self
    {
        return new self(
            portfolio_id: $dto->portfolioId(),
            symbol: $dto->symbol(),
            amount: $dto->amount(),
            id: $dto->id(),
            recorded_at: $dto->recordedAt(),
        );
    }
}
