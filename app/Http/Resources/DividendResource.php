<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DividendResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'symbol' => $this->symbol,
            'amount' => $this->amount,
            'recorded_at' => $this->resource->recorded_at,
        ];
    }
}
