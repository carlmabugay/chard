<?php

namespace App\Http\Resources\Dividend;

use App\Http\Resources\Portfolio\PortfolioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DividendResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id(),
            'symbol' => $this->resource->symbol(),
            'amount' => $this->resource->amount(),
            'recorded_at' => $this->resource->recordedAt(),
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
