<?php

namespace App\Application\CashFlow\DTOs;

class StoreCashFlowDTO
{
    public function __construct(
        public int $portfolio_id,
        public string $type,
        public float $amount,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            portfolio_id: $data['portfolio_id'],
            type: $data['type'],
            amount: $data['amount'],
            id: $data['id'] ?? null,
        );
    }
}
