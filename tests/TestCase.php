<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            putenv('DB_CONNECTION=mysql');
            $_ENV['DB_CONNECTION'] = 'mysql';
            $_SERVER['DB_CONNECTION'] = 'mysql';
            putenv('DB_DATABASE');
            unset($_ENV['DB_DATABASE'], $_SERVER['DB_DATABASE']);
        }

        parent::setUp();

        if (! extension_loaded('pdo_sqlite')) {
            $this->app['config']->set('database.default', 'mysql');
            $this->app['config']->set(
                'database.connections.mysql.database',
                env('DB_DATABASE', 'open9_cargo_v1')
            );
        }
    }
}
