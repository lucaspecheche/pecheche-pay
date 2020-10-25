<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
    }
}
