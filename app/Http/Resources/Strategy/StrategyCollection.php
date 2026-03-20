<?php

namespace App\Http\Resources\Strategy;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StrategyCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'data' => $this->collection,
            'total' => $this->count(),
        ];
    }
}
