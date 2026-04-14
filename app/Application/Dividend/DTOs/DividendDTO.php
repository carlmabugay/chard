<?php

namespace App\Application\Dividend\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class DividendDTO
{
    public function __construct(
        private readonly int $portfolio_id,
        private readonly string $symbol,
        private readonly float $amount,
        private readonly ?string $recorded_at,
        private readonly ?int $id = null,
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

    public static function fromModel(Model $model): self
    {
        return new self(
            portfolio_id: $model->portfolio_id,
            symbol: $model->symbol,
            amount: $model->amount,
            recorded_at: $model->recorded_at,
            id: $model->id,
        );
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            portfolio_id: $request->validated('portfolio_id'),
            symbol: $request->validated('symbol'),
            amount: $request->validated('amount'),
            recorded_at: $request->validated('recorded_at'),
            id: $request->input('id'),
        );
    }
}
