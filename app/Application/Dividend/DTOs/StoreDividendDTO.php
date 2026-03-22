<?php

namespace App\Application\Dividend\DTOs;

readonly class StoreDividendDTO
{
    public function __construct(
        private int $portfolio_id,
        private string $symbol,
        private float $amount,
        public ?int $id,
        private ?string $recorded_at,
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

    public function recordedAt(): ?string
    {
        return $this->recorded_at;
    }

    public static function fromRequest(array $request): self
    {
        return new self(
            portfolio_id: $request['portfolio_id'],
            symbol: $request['symbol'],
            amount: $request['amount'],
            id: $request['id'] ?? null,
            recorded_at: $request['recorded_at'],

        );
    }
}
