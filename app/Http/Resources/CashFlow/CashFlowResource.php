<?php

namespace App\Http\Resources\CashFlow;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashFlowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'portfolio_id' => $this->resource->portfolioId(),
            'id' => $this->resource->id(),
            'type' => $this->resource->type(),
            'amount' => $this->resource->amount(),
            'created_at' => $this->resource->createdAt(),
            'updated_at' => $this->resource->updatedAt(),
        ];
    }

    public function with($request): array
    {

        return [
            'success' => true,
        ];
    }
}
