<?php

namespace App\Providers;

use App\Domain\Portfolio\Contracts\Read\PortfolioReadRepositoryInterface;
use App\Domain\Portfolio\Contracts\Write\PortfolioWriteRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Read\EloquentPortfolioReadRepository;
use App\Infrastructure\Persistence\Eloquent\Write\EloquentPortfolioWriteRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public $bindings = [
        PortfolioReadRepositoryInterface::class => EloquentPortfolioReadRepository::class,
        PortfolioWriteRepositoryInterface::class => EloquentPortfolioWriteRepository::class,
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
