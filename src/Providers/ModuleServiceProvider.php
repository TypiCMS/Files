<?php

namespace TypiCMS\Modules\Files\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Services\FileUploader;
use TypiCMS\Modules\Files\Composers\SidebarViewComposer;
use TypiCMS\Modules\Files\Facades\Files;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Observers\FileObserver;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.files');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'files');

        $this->publishes([
            __DIR__.'/../../database/migrations/create_files_table.php.stub' => getMigrationFileName('create_files_table'),
            __DIR__.'/../../database/migrations/create_model_has_files_table.php.stub' => getMigrationFileName('create_model_has_files_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/files'),
        ], 'views');

        AliasLoader::getInstance()->alias('Files', Files::class);

        // Observers
        File::observe(new FileObserver(new FileUploader()));

        View::composer('core::admin._sidebar', SidebarViewComposer::class);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('Files', File::class);
    }
}
