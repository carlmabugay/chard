<?php

namespace App\Providers;

use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public $bindings = [
        PortfolioReadRepositoryInterface::class => EloquentPortfolioReadRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
