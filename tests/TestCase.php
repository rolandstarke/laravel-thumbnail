<?php

namespace Rolandstarke\Thumbnail\Tests;

use Rolandstarke\Thumbnail\ThumbnailServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        $app->useStoragePath(realpath(__DIR__ . '/../storage'));
        $app['config']->set('filesystems.disks.public.root', storage_path('app/public'));
    }


    protected function getPackageProviders($app)
    {
        return [
            ThumbnailServiceProvider::class,
            \Intervention\Image\ImageServiceProvider::class
        ];
    }
}
