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
                $router->get('files', 'AdminController@index')->name('admin::index-files');
                $router->get('files/create', 'AdminController@create')->name('admin::create-file');
                $router->get('files/{file}/edit', 'AdminController@edit')->name('admin::edit-file');
                $router->post('files', 'AdminController@store')->name('admin::store-file');
                $router->put('files/{file}', 'AdminController@update')->name('admin::update-file');
                $router->post('files/sort', 'AdminController@sort')->name('admin::sort-files');
                $router->post('files/upload', 'AdminController@upload')->name('admin::upload-files');
                $router->delete('files/{file}', 'AdminController@destroy')->name('admin::destroy-file');
            });
        });
    }
}
