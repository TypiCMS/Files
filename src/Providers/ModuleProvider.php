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
use TypiCMS\Modules\Files\Services\Form\FileForm;
use TypiCMS\Modules\Files\Services\Form\FileFormLaravelValidator;
use TypiCMS\Observers\FileObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Add dirs
        View::addNamespace('files', __DIR__ . '/../views/');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'files');
        $this->publishes([
            __DIR__ . '/../config/' => config_path('typicms/files'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../migrations/' => base_path('/database/migrations'),
        ], 'migrations');

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

        $app->bind('TypiCMS\Modules\Files\Services\Form\FileForm', function (Application $app) {
            return new FileForm(
                new FileFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Files\Repositories\FileInterface')
            );
        });
    }
}
