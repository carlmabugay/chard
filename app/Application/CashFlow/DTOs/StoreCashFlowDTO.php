<?php

namespace App\Application\CashFlow\DTOs;

use App\Enums\CashFlowType;

readonly class StoreCashFlowDTO
{
    public function __construct(
        private int $portfolio_id,
        public CashFlowType $type,
        public float $amount,
        public ?int $id = null,
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

    public static function fromRequest(array $request): self
    {
        return new self(
            portfolio_id: $request['portfolio_id'],
            type: CashFlowType::fromInput($request['type']),
            amount: $request['amount'],
            id: $request['id'] ?? null,
        );
    }
}
