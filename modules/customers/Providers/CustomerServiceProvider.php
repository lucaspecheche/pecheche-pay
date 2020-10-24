<?php

namespace Customers\Providers;

use Customers\Rules\CustomerIdentifier;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerRules();
    }

    public function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function registerRules(): void
    {
        $this->app->validator->extend('is_customer', CustomerIdentifier::class);

        $this->app->validator->replacer('is_customer', function($message, $attribute, $rule, $parameters) {
            return str_replace(':models', implode(', ', $parameters), $message);
        });
    }
}
