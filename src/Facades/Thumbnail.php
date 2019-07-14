<?php

namespace Rolandstarke\Thumbnail\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static \Rolandstarke\Thumbnail\Thumbnail src(string $path, string $disk = null)
 * @method static \Rolandstarke\Thumbnail\Thumbnail preset(string $preset)
 */
class Thumbnail extends Facade
{
    protected static function getFacadeAccessor()
    {
        return static::$app[\Rolandstarke\Thumbnail\Thumbnail::class];
    }
}
