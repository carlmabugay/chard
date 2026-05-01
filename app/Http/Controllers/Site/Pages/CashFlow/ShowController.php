<?php

namespace App\Http\Controllers\Site\Pages\CashFlow;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlowResource;
use App\Models\CashFlow;
use Illuminate\Support\Facades\Gate;

final class ShowController extends Controller
{
    public function __invoke(CashFlow $cash_flow)
    {
        Gate::authorize('view', $cash_flow);

        return CashFlowResource::make($cash_flow);
    }
}
