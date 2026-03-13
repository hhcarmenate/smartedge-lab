<?php

namespace App\Providers;

use App\Contracts\MarketData\MarketDataProviderInterface;
use App\Services\MarketData\Massive\MassiveClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MarketDataProviderInterface::class, MassiveClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
