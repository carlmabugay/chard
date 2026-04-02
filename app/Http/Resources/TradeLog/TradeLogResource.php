<?php

namespace App\Http\Resources\TradeLog;

use App\Http\Resources\Portfolio\PortfolioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id(),
            'symbol' => $this->resource->symbol(),
            'type' => $this->resource->type(),
            'price' => $this->resource->price(),
            'shares' => $this->resource->shares(),
            'fees' => $this->resource->fees(),
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
