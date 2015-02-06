<?php
namespace TypiCMS\Modules\Files\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Files\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('files', 'TypiCMS\Modules\Files\Models\File');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router) {
            /**
             * Admin routes
             */
            $router->resource('admin/files', 'AdminController');
            $router->post('admin/files/sort', ['as' => 'admin.files.sort', 'uses' => 'AdminController@sort']);
            $router->post('admin/files/upload', ['as' => 'admin.files.upload', 'uses' => 'AdminController@upload']);

            /**
             * API routes
             */
            $router->resource('api/files', 'ApiController');
        });
    }

}
