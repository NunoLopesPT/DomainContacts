<?php

namespace NunoLopes\ContactsListLaravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use NunoLopes\ContactsListLaravel\Contracts\Database\ContactsRepository;
use NunoLopes\ContactsListLaravel\Repositories\Database\Eloquent\EloquentContactsRepository;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->handleRoutes();
        $this->handleViews();
        $this->publishAssets();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            ContactsRepository::class,
            EloquentContactsRepository::class
        );
    }

    /**
     * Handles routes.
     *
     * @return void
     */
    private function handleRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }

    /**
     * Handles Views.
     *
     * @return void
     */
    private function handleViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'contacts');
    }

    /**
     * Publish Assets
     *
     * @return void
     */
    private function publishAssets(): void
    {
        $this->publishes([
            __DIR__.'/../public/' => public_path(),
        ], 'public');
    }
}
