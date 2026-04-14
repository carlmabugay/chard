<?php

namespace App\Application\TradeLog\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class TradeLogDTO
{
    public function __construct(
        private readonly int $portfolio_id,
        private readonly string $symbol,
        private readonly string $type,
        private readonly float $price,
        private readonly int $shares,
        private readonly float $fees,
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

    public static function fromModel(Model $model): self
    {
        return new self(
            portfolio_id: $model->portfolio_id,
            symbol: $model->symbol,
            type: $model->type,
            price: $model->price,
            shares: $model->shares,
            fees: $model->fees,
            id: $model->id,
        );
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            portfolio_id: $request->validated('portfolio_id'),
            symbol: $request->validated('symbol'),
            type: $request->validated('type'),
            price: $request->validated('price'),
            shares: $request->validated('shares'),
            fees: $request->validated('fees'),
            id: $request->input('id'),
        );
    }
}
