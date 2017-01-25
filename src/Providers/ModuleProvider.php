<?php

namespace TypiCMS\Modules\Files\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Files\Composers\SidebarViewComposer;
use TypiCMS\Modules\Files\Facades\Files;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Repositories\EloquentFile;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.files'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['files' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'files');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'files');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/files'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias('Files', Files::class);

        // Observers
        File::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        $app->bind('Files', EloquentFile::class);
    }
}
