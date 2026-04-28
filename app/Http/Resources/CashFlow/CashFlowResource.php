<?php

namespace App\Http\Resources\CashFlow;

use App\Http\Resources\PortfolioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashFlowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id(),
            'type' => $this->resource->type(),
            'amount' => $this->resource->amount(),
            'created_at' => $this->resource->createdAt(),
            'updated_at' => $this->resource->updatedAt(),
            'portfolio' => PortfolioResource::make($this->resource->portfolio()),
        ];
    }

    public function with($request): array
    {
        return [
            'success' => true,
        ];
    }
}
