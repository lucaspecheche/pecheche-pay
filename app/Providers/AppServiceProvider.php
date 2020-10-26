<?php

namespace App\Providers;

use App\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Request::class, static function (Application $app) {
            return Request::createFromBase($app->make('request'));
        });

        $this->app->register(ModuleServiceProvider::class);
    }

    public function boot(): void
    {
        $this->initialDatabase();

    }

    private function initialDatabase(): void
    {
        $database = config('database.connections.sqlite.database');

        if(!file_exists($database)) {
            file_put_contents($database, '');
        }
    }
}
