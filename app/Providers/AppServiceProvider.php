<?php

namespace App\Providers;

use App\Models\CashFlow;
use App\Models\Dividend;
use App\Models\Portfolio;
use App\Models\Strategy;
use App\Models\TradeLog;
use App\Policies\CashFlowPolicy;
use App\Policies\DividendPolicy;
use App\Policies\PortfolioPolicy;
use App\Policies\StrategyPolicy;
use App\Policies\TradeLogPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::setRootView('app');
        Gate::policy(Portfolio::class, PortfolioPolicy::class);
        Gate::policy(Dividend::class, DividendPolicy::class);
        Gate::policy(Strategy::class, StrategyPolicy::class);
        Gate::policy(CashFlow::class, CashFlowPolicy::class);
        Gate::policy(TradeLog::class, TradeLogPolicy::class);
    }
}
