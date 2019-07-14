<?php

namespace Rolandstarke\Thumbnail;

use Rolandstarke\Thumbnail\Console\Commands\Purge;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Rolandstarke\Thumbnail\Http\Controller\ImageController;

class ThumbnailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/thumbnail.php', 'thumbnail'
        );
        
        $this->app->bind(Thumbnail::class, function () {
            return new Thumbnail(config('thumbnail'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/thumbnail.php' => config_path('thumbnail.php'),
            ], 'thumbnail-config');

            $this->commands([
                Purge::class,
            ]);
        }

        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        foreach (config('thumbnail.presets', []) as $presetName => $preset) {
            if (is_array($preset) && isset($preset['destination'])) {
                $url = Storage::disk($preset['destination']['disk'])->url($preset['destination']['path'] . '{file}');
                $route = parse_url($url, PHP_URL_PATH);

                Route::get($route, ImageController::class . '@index')
                    ->where('file', '.+')
                    ->defaults('preset', $presetName);
            }
        }
    }
}
