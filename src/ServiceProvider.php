<?php
namespace NunoLopes\LaravelContactsAPI;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Passport\Passport;
use NunoLopes\LaravelContactsAPI\Contracts\Database\AccessTokenRepository;
use NunoLopes\LaravelContactsAPI\Contracts\Database\ContactsRepository;
use NunoLopes\LaravelContactsAPI\Contracts\Database\UsersRepository;
use NunoLopes\LaravelContactsAPI\Contracts\Utilities\Authentication;
use NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent\EloquentAccessTokenRepository;
use NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent\EloquentContactsRepository;
use NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent\EloquentUsersRepository;
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
            UsersRepository::class,
            EloquentUsersRepository::class
        );
        $this->app->bind(
            Authentication::class,
            LaravelAuthentication::class
        );
        $this->app->bind(
            AccessTokenRepository::class,
            EloquentAccessTokenRepository::class
        );
    }

    /**
     * Handles routes.
     *
     * @return void
     */
    private function handleRoutes(): void
    {
        Route::prefix('api')
            ->group(
                __DIR__ . '/../routes/api.php'
            );

        Passport::routes();

        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }

    /**
     * Handles Views.
     *
     * @return void
     */
    private function handleViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'laravel-contacts-api');
    }
}
