<?php

namespace App\Application\TradeLog\DTOs;

readonly class StoreTradeLogDTO
{
    public function __construct(
        private int $portfolio_id,
        private string $symbol,
        public string $type,
        public float $price,
        public float $shares,
        public float $fees,
        public ?int $id = null,
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

    public function shares(): float
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

    public static function fromRequest(array $request): self
    {
        return new self(
            portfolio_id: $request['portfolio_id'],
            symbol: $request['symbol'],
            type: $request['type'],
            price: $request['price'],
            shares: $request['shares'],
            fees: $request['fees'],
            id: $request['id'] ?? null,
        );
    }
}
