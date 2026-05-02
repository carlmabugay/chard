<?php

namespace App\Http\Controllers\Site\Pages\TradeLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\TradeLog\TradeLogResource;
use App\Models\TradeLog;
use Illuminate\Support\Facades\Gate;

class ShowController extends Controller
{
    public function __invoke(TradeLog $trade_log)
    {
        Gate::authorize('view', $trade_log);

        return TradeLogResource::make($trade_log);
    }
}
