<?php

namespace App\Http\Resources\TradeLog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'symbol' => $this->symbol,
            'type' => $this->type,
            'price' => $this->price,
            'shares' => $this->shares,
            'fees' => $this->fees,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
