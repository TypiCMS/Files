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
     *
     * @return null
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {
            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function (Router $router) {
                $router->get('files', 'AdminController@index')->name('admin::index-files')->middleware('can:see-all-files');
                $router->get('files/create', 'AdminController@create')->name('admin::create-file')->middleware('can:create-file');
                $router->get('files/{file}/edit', 'AdminController@edit')->name('admin::edit-file')->middleware('can:update-file');
                $router->post('files', 'AdminController@store')->name('admin::store-file')->middleware('can:create-file');
                $router->put('files/{file}', 'AdminController@update')->name('admin::update-file')->middleware('can:update-file');
                $router->patch('files/{ids}', 'AdminController@ajaxUpdate')->name('admin::update-file-ajax')->middleware('can:update-file');
                $router->delete('files/{ids}', 'AdminController@destroyMultiple')->name('admin::destroy-file')->middleware('can:delete-file');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->get('files', 'ApiController@index')->name('api::index-files');
                $router->post('files/sort', 'ApiController@sort')->name('admin::sort-files');
                $router->patch('files/{file}', 'ApiController@update')->name('api::update-file');
                $router->delete('files/{file}', 'ApiController@destroy')->name('api::destroy-file');
            });
        });
    }
}
