<?php

namespace TypiCMS\Modules\Files\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Files\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {
            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function (Router $router) {
                $router->get('files', 'AdminController@index')->name('admin::index-files')->middleware('can:read files');
                $router->get('files/{file}/edit', 'AdminController@edit')->name('admin::edit-file')->middleware('can:update files');
                $router->put('files/{file}', 'AdminController@update')->name('admin::update-file')->middleware('can:update files');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('files', 'ApiController@index')->middleware('can:read files');
                    $router->post('files', 'ApiController@store')->middleware('can:create files');
                    $router->post('files/sort', 'ApiController@sort')->middleware('can:update files'); // @deprecated
                    $router->patch('files/{ids}', 'ApiController@move')->middleware('can:update files');
                    $router->delete('files/{file}', 'ApiController@destroy')->middleware('can:delete files');
                });
            });
        });
    }
}
