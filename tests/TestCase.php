<?php

namespace Aasanakey\Smsonline\Tests;

use Aasanakey\Smsonline\SmsonlineServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        //$this->withFactories(__DIR__.'/../database/factories');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SmsonlineServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);

        // $app['config']->set('smsonline.api_key',env('SMSONLINE_API_KEY'));
        // $app['config']->set('smsonline.sender_id',env('SMSONLINE_SENDER_ID'));
        
    }
}