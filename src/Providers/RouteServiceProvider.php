<?php

namespace TypiCMS\Modules\Files\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

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
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {
            /*
             * Admin routes
             */
            $router->get('admin/files', 'AdminController@index')->name('admin::index-files');
            $router->get('admin/files/create', 'AdminController@create')->name('admin::create-files');
            $router->get('admin/files/{file}/edit', 'AdminController@edit')->name('admin::edit-files');
            $router->post('admin/files', 'AdminController@store')->name('admin::store-files');
            $router->put('admin/files/{file}', 'AdminController@update')->name('admin::update-files');
            $router->post('admin/files/sort', 'AdminController@sort')->name('admin::sort-files');
            $router->post('admin/files/upload', 'AdminController@upload')->name('admin::upload-files');

            /*
             * API routes
             */
            $router->get('api/files', 'ApiController@index')->name('api::index-files');
            $router->post('api/files', 'ApiController@store')->name('api::store-files');
            $router->put('api/files/{file}', 'ApiController@update')->name('api::update-files');
            $router->delete('api/files/{file}', 'ApiController@destroy')->name('api::destroy-files');
        });
    }
}
