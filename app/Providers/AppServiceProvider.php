<?php

namespace App\Providers;

use App\Rules\CustomerIdentifier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        /** @var \Illuminate\Validation\Factory $validator */
        $validator = $this->app->validator;

        $validator->extend('is_customer', CustomerIdentifier::class);

        $validator->replacer('is_customer', function($message, $attribute, $rule, $parameters) {
            return str_replace(':models', implode(', ', $parameters), $message);
        });

    }
}
