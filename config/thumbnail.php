<?php

return [

    /**
     * Reject attempts to maliciously create images by signing the generated
     * request with a hash based on the request parameters and this signing key.
     */
    'signing_key' => sha1(env('APP_KEY', '')),


    /**
     * Memory limit for generating the thumbnails.
     * e.g. 256M, 512M 1024M 2048M
     */
    'memory_limit' => '1024M',


    /**
     * Load the original images from the following sources.
     *
     * Hint: When using `Thumbnail::src(...)->url()` You will get shorter urls
     *       if you add the subdir you are loading the image from.
     *       E.g. add `storage_path('/useruploads')` instead of `storage_path('/')`.
     */
    'allowedSources' => [
        'a' => app_path(),
        'r' => resource_path(),
        'p' => public_path(),
        's' => storage_path(),
        'http' => 'http://', //allow images to be loaded from http
        'https' => 'https://',
        'ld' => ['disk' => 'local', 'path' => '/'], //allow images to be loaded from `Storage::disk('local')`
        'pd' => ['disk' => 'public', 'path' => '/'],
    ],


    /**
     * Thumbnail settings are grouped in presets.
     * So that you can have different settings for e.g. profile and album pictures.
     */
    'presets' => [
        'default' => [
            /**
             * Store the generated images here.
             *
             * Note: Every preset needs an unique path.
             */
            'destination' => ['disk' => 'public', 'path' => '/thumbnails/default/'],
        ],

        //add more presets e.g. "avatar".
        'avatar' => [
            'destination' => ['disk' => 'public', 'path' => '/thumbnails/avatar/'],
            /**
             * add default params for this preset
             */
            'smartcrop' => '64x64',
        ],
    ],


    /**
     * Available filters to modify the images.
     */
    'filters' => [
        Rolandstarke\Thumbnail\Filter\Resize::class,
        Rolandstarke\Thumbnail\Filter\Blur::class,
        Rolandstarke\Thumbnail\Filter\Greyscale::class,
    ],
];
