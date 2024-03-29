<?php

namespace ikepu_tp\LaravelAdmin;

use ErrorException;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/laravel-admin.php', 'laravel-admin');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPublishing();
        $this->defineRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . "/resources/views", "laravelAdmin");
        Paginator::useBootstrap();
        Blade::componentNamespace("ikepu_tp\\resources\\views\\components", "laravelAdmin");
    }

    /**
     * Register the package's publishable resources.
     */
    private function registerPublishing()
    {

        if (!$this->app->runningInConsole()) return;

        $this->publishes([
            __DIR__ . '/config/laravel-admin.php' => base_path('config/laravel-admin.php'),
        ], 'laravelAdmin-config');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/laravelAdmin'),
        ], 'laravelAdmin-views');

        $this->publishes([
            __DIR__ . "/routes/web.php" => base_path("routes/laravel-admin.php"),
        ], "laravelAdmin-route");
    }

    /**
     * Define the Sanctum routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        try {
            $this->loadRoutesFrom(base_path("routes/laravel-admin.php"));
        } catch (ErrorException $e) {
            if (!file_exists(base_path("routes/laravel-admin.php"))) copy(__DIR__ . "/routes/web.php", base_path("routes/laravel-admin.php"));
            $this->loadRoutesFrom(base_path("routes/laravel-admin.php"));
        }
    }
}
