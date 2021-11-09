<?php

namespace TypiCMS\Modules\Files\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Files\Http\Controllers\AdminController;
use TypiCMS\Modules\Files\Http\Controllers\ApiController;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('files', [AdminController::class, 'index'])->name('index-files')->middleware('can:read files');
            $router->get('files/{file}/edit', [AdminController::class, 'edit'])->name('edit-file')->middleware('can:read files');
            $router->put('files/{file}', [AdminController::class, 'update'])->name('update-file')->middleware('can:update files');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('files', [ApiController::class, 'index'])->middleware('can:read files');
            $router->post('files', [ApiController::class, 'store'])->middleware('can:create files');
            $router->patch('files/{ids}', [ApiController::class, 'move'])->middleware('can:update files');
            $router->delete('files/{file}', [ApiController::class, 'destroy'])->middleware('can:delete files');
        });
    }
}
