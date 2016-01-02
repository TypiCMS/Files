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
            $router->get('admin/files', ['as' => 'admin.files.index', 'uses' => 'AdminController@index']);
            $router->get('admin/files/create', ['as' => 'admin.files.create', 'uses' => 'AdminController@create']);
            $router->get('admin/files/{file}/edit', ['as' => 'admin.files.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/files', ['as' => 'admin.files.store', 'uses' => 'AdminController@store']);
            $router->put('admin/files/{file}', ['as' => 'admin.files.update', 'uses' => 'AdminController@update']);
            $router->post('admin/files/sort', ['as' => 'admin.files.sort', 'uses' => 'AdminController@sort']);
            $router->post('admin/files/upload', ['as' => 'admin.files.upload', 'uses' => 'AdminController@upload']);

            /*
             * API routes
             */
            $router->get('api/files', ['as' => 'api.files.index', 'uses' => 'ApiController@index']);
            $router->post('api/files', ['as' => 'api.files.store', 'uses' => 'ApiController@store']);
            $router->put('api/files/{file}', ['as' => 'api.files.update', 'uses' => 'ApiController@update']);
            $router->delete('api/files/{file}', ['as' => 'api.files.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
