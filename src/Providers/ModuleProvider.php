<?php

namespace TypiCMS\Modules\Files\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Services\FileUploader;
use TypiCMS\Modules\Files\Composers\SidebarViewComposer;
use TypiCMS\Modules\Files\Facades\Files;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Observers\FileObserver;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.files');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['files' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'files');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/files'),
        ], 'views');

        AliasLoader::getInstance()->alias('Files', Files::class);

        // Observers
        File::observe(new FileObserver(new FileUploader()));

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Files', File::class);
    }
}
