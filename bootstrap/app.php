<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

//Enable app functions
 $app->withFacades();
 $app->withEloquent();


 //Handler entrypoints
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

//Register Configs
$app->configure('app');

//Register Providers
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\ModuleServiceProvider::class);

//Register Routes
$app->router->group([], function ($router) {
    require __DIR__.'/../routes/api.php';
});

return $app;
