<?php

namespace App\Application\Portolio\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class PortfolioDTO
{
    public function __construct(
        private readonly int $user_id,
        private readonly string $name,
        private readonly ?int $id = null,
    ) {}

    public function userId(): int
    {
        return $this->user_id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public static function fromModel(Model $model): self
    {
        return new self(
            user_id: $model->id,
            name: $model->name,
            id: $model->id,
        );
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            user_id: $request->user()->id,
            name: $request->validated('name'),
            id: $request->input('id'),
        );
    }
}
