<?php

namespace App\Http\Resources\TradeLog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TradeLogCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
