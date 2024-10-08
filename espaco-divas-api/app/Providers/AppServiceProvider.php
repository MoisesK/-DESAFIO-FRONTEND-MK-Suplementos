<?php

namespace App\Providers;

use App\Repository\Order\OrderEloquentRepository;
use App\Repository\Order\OrderRepository;
use App\Repository\Product\ProductEloquentRepository;
use App\Repository\Product\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductRepository::class, ProductEloquentRepository::class);
        $this->app->singleton(OrderRepository::class, OrderEloquentRepository::class);
    }


    public function boot(): void
    {
        if (env('APP_ENV') == 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
