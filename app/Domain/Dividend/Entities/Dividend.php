<?php

namespace App\Domain\Dividend\Entities;

use App\Application\Dividend\DTOs\StoreDividendDTO;
use Illuminate\Database\Eloquent\Model;

readonly class Dividend
{
    public function __construct(
        private int $portfolio_id,
        private string $symbol,
        private float $amount,
        private ?int $id = null,
        private ?string $recorded_at = null,
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

    public static function fromEloquentModel(Model $model): self
    {
        return new self(
            portfolio_id: $model->portfolio_id,
            symbol: $model->symbol,
            amount: $model->amount,
            id: $model->id,
            recorded_at: $model->recorded_at,
        );
    }

    public static function fromDTO(StoreDividendDTO $dto): self
    {
        return new self(
            portfolio_id: $dto->portfolioId(),
            symbol: $dto->symbol(),
            amount: $dto->amount(),
            recorded_at: $dto->recordedAt(),
        );
    }
}
