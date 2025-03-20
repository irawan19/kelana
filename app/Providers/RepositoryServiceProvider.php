<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\BarangRepositoryInterfaces;
use App\Repository\BarangRepository;
use App\Interfaces\PenawaranRepositoryInterfaces;
use App\Repository\PenawaranRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BarangRepositoryInterface::class, BarangRepository::class, PenawaranRepositoryInterface::class, PenawaranRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
