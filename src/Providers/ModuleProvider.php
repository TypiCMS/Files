<?php
namespace TypiCMS\Modules\Files\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Repositories\CacheDecorator;
use TypiCMS\Modules\Files\Repositories\EloquentFile;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.files'
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'files');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'files');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/files'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests'),
        ], 'tests');

        AliasLoader::getInstance()->alias(
            'Files',
            'TypiCMS\Modules\Files\Facades\Facade'
        );

        // Observers
        File::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Files\Providers\RouteServiceProvider');

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Files\Composers\SideBarViewComposer');

        $app->bind('TypiCMS\Modules\Files\Repositories\FileInterface', function (Application $app) {
            $repository = new EloquentFile(new File);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['galleries', 'files'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

    }
}
