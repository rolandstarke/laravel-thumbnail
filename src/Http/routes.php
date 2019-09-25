<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Rolandstarke\Thumbnail\Http\Controller\ImageController;


foreach (config('thumbnail.presets', []) as $presetName => $preset) {
    if (is_array($preset) && isset($preset['destination'])) {
        $url = Storage::disk($preset['destination']['disk'])->url($preset['destination']['path'] . '{file}');
        $route = parse_url($url, PHP_URL_PATH);

        Route::get($route, ImageController::class . '@index')
            ->where('file', '.+')
            ->defaults('preset', $presetName);
    }
}
