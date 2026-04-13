<?php

namespace App\Application\CashFlow\DTOs;

use App\Enums\CashFlowType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class CashFlowDTO
{
    public function __construct(
        private readonly int $portfolio_id,
        private readonly CashFlowType $type,
        private readonly float $amount,
        private readonly ?int $id = null,
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

    public static function fromModel(Model $model): self
    {
        return new self(
            portfolio_id: $model->portfolio->id,
            type: $model->type,
            amount: $model->amount,
            id: $model->id,
        );
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            portfolio_id: $request->validated('portfolio_id'),
            type: CashFlowType::fromInput($request->validated('type')),
            amount: $request->validated('amount'),
            id: $request->input('id'),
        );
    }
}
