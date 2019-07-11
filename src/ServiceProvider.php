<?php
namespace NunoLopes\LaravelContactsAPI;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use NunoLopes\LaravelContactsAPI\Contracts\Database\ContactsRepository;
use NunoLopes\LaravelContactsAPI\Contracts\Utilities\Authentication;
use NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent\EloquentContactsRepository;
use NunoLopes\LaravelContactsAPI\Utilities\LaravelAuthentication;

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
        $this->app->bind(
            Authentication::class,
            LaravelAuthentication::class
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
        $this->loadViewsFrom(__DIR__ . '/../views', 'contacts');
    }
}
