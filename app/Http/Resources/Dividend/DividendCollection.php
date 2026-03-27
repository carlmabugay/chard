<?php

namespace App\Http\Resources\Dividend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DividendCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
