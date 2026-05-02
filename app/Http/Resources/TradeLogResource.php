<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'created_at' => Carbon::make($this->created_at)->format('F d, Y'),
            'updated_at' => Carbon::make($this->updated_at)->format('F d, Y'),
        ];
    }
}
