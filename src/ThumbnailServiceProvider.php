<?php

namespace Rolandstarke\Thumbnail;

use Rolandstarke\Thumbnail\Console\Commands\Purge;
use Illuminate\Support\ServiceProvider;

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

        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }
}
