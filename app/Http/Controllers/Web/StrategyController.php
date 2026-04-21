<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Strategy\StoreStrategyRequest;
use App\Models\Strategy;
use Illuminate\Support\Facades\Redirect;

class StrategyController extends Controller
{
    public function __invoke(StoreStrategyRequest $request)
    {

        $data = $request->validated();

        $strategy = new Strategy;
        $strategy->name = $data['name'];
        $strategy->user_id = auth()->user()->id;
        $strategy->save();

        return Redirect::route('strategy.index')->with('success', 'Strategy created.');
    }
}
