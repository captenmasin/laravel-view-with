<?php

namespace Captenmasin\LaravelViewWith\Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use Captenmasin\LaravelViewWith\LaravelViewWithServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        Factory::guessFactoryNamesUsing(function ($class) {
            return 'Captenmasin\\LaravelViewWith\\Database\\Factories\\'.class_basename($class).'Factory';
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelViewWithServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('test_user_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->softDeletes();
        });
    }
}
