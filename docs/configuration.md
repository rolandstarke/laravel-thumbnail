---
layout: default
title: Configuration
---

# Configuration

Publish the configuration file with the following command.

```bash
php artisan vendor:publish --tag=thumbnail-config
```

The configuration file is located at `config/thumbnail.php`.

## Parameters

### signing_key

```php
'signing_key' => sha1(env('APP_KEY')),
```

Reject attempts to maliciously create images by signing the generated request with a hash based on the request parameters and this signing key.

### memory_limit

```php
'memory_limit' => '1024M',
```

Memory limit that will be set when creating a thumbnail.

### allowedSources

```php
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
```

The directories where source images are found. Can be either an absolute path or an array with the diskname and path of a [filesystem](https://laravel.com/docs/filesystem){:target="_blank"}.

*Hint: The key (`'a', 'r', ...`) is used in the thumbnail URL. If you load images from a subdirectory e.g. `storage/app/useruploads` you can add this path as an allowed source as well to get shorter URLs.*

### presets

```php
'presets' => [
    'avatar' => [
        'destination' => ['disk' => 'public', 'path' => '/thumbnails/avatar/'],
        //add default parameters
        'smartcrop' => '64x64',
    ],
    //...
],
```

Thumbnail settings are grouped in presets. So that you can have different settings for e.g. profile and album pictures.
The destination must be a public accecible [filesystem](https://laravel.com/docs/filesystem){:target="_blank"}, created thumbnails are stored there. Every preset must have a unique destination.

### filters

```php
'filters' => [
    Rolandstarke\Thumbnail\Filter\Resize::class,
    Rolandstarke\Thumbnail\Filter\Blur::class,
    //...
],
```

List of filters that are called to create thumbnails. You can add your own filter here, to find out more read: [writing your own filter](writing-own-filter.html).
