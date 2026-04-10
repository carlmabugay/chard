<?php

namespace App\Providers;

use App\Models\Portfolio;
use App\Models\Strategy;
use App\Policies\PortfolioPolicy;
use App\Policies\StrategyPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(Portfolio::class, PortfolioPolicy::class);
        Gate::policy(Strategy::class, StrategyPolicy::class);
    }
}
