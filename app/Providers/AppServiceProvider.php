<?php

namespace App\Providers;

use App\Tasks\Domain\JobRepositoryInterface;
use App\Tasks\Infrastructure\Storage\Postgres\JobRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
