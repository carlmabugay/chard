<?php

namespace App\Http\Resources\Dividend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DividendResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'portfolio_id' => $this->resource->portfolioId(),
            'id' => $this->resource->id(),
            'symbol' => $this->resource->symbol(),
            'amount' => $this->resource->amount(),
            'recorded_at' => $this->resource->recordedAt(),
        ];
    }

    public function with($request): array
    {
        return [
            'success' => true,
        ];
    }
}
