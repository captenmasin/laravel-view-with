<?php

namespace Captenmasin\LaravelViewWith\Tests;

use Illuminate\Routing\Router;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar;
use Captenmasin\LaravelViewWith\Tests\Support\TestUserModel;

class RouteTest extends TestCase
{
    /** @test */
    public function normal_view_method_works()
    {
        Route::view('test', 'routedata::tests.basic', ['bar' => 'baz']);

        $response = $this->get('test')->getContent();

        $this->assertSame('Foo baz', $response);
    }

    /** @test */
    public function new_macro_matches_current_view_method()
    {
        Route::viewWithData('test', 'routedata::tests.basic', ['bar' => 'baz']);

        $response = $this->get('test')->getContent();

        $this->assertSame('Foo baz', $response);
    }

    /** @test */
    public function new_macro_parses_closures_in_model_binding()
    {
        $router = $this->getRouter();
        $user = TestUserModel::factory()->create()->first();
        $router->viewWithData('test/{TestUserModel}', 'routedata::tests.user', [
            'TestUserModel' => fn (TestUserModel $TestUserModel) => $TestUserModel,
        ]);

        $response = $this->get('test/'.$user->id)->getContent();

        $this->assertSame('Name '.$user->name, $response);
    }

    protected function getRouter(): Router
    {
        $container = new Container();

        $router = new Router(new Dispatcher(), $container);

        $container->singleton(Registrar::class, function () use ($router) {
            return $router;
        });

        return $router;
    }
}
