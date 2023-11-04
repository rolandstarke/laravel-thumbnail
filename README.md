
# Laravel Thumbnail

[![Build](https://github.com/rolandstarke/laravel-thumbnail/actions/workflows/php.yml/badge.svg)](https://github.com/rolandstarke/laravel-thumbnail/actions/workflows/php.yml)
[![PHP Version](https://img.shields.io/packagist/php-v/rolandstarke/laravel-thumbnail.svg)](https://github.com/rolandstarke/laravel-thumbnail/blob/master/composer.json)
[![Latest Stable Version](https://poser.pugx.org/rolandstarke/laravel-thumbnail/v/stable)](https://packagist.org/packages/rolandstarke/laravel-thumbnail)
[![LICENSE](https://img.shields.io/packagist/l/rolandstarke/laravel-thumbnail.svg)](https://github.com/rolandstarke/laravel-thumbnail/blob/master/LICENSE)

![image](docs/assets/img/desert.jpg) ![image resized](docs/assets/img/desert_resized.jpg)

```html
<img src="{{ Storage::disk('public')->url('desert.jpg') }}">
<!-- <img src="/storage/desert.jpg"> -->

<img src="{{ Thumbnail::src('desert.jpg', 'public')->smartcrop(200, 200)->url() }}">
<!-- <img src="/storage/jhf47.jpg?src=desert.jpg&smartcrop=200x200"> -->
```

Laravel package to resize images with specially formatted URLs.

- Generates the URL without touching the filesystem.
- Rendered thumbnails are stored and subsequent requests are directly served from your nginx/apache.
- The URL is signed to prevent malicious parameters.

## Getting Started

### Requirements

- GD Library or Imagick
- php >= 7.1.3
- laravel >= 5.5

### Installation

To install the most recent version with composer run the following command.

```bash
composer require rolandstarke/laravel-thumbnail
```

## Usage

```php
<img src="{{ Thumbnail::src($path)->crop(64, 64)->url() }}" />


<?php
    //load image from dir
    \Thumbnail::src(public_path('images/example.jpeg'));

    //load image from Storage::disk('local')
    \Thumbnail::src('userimage.jpg', 'local' /* disk */);

    //load image from website
    \Thumbnail::src('https://picsum.photos/200');
?>
```

Checkout the [docs](https://rolandstarke.github.io/laravel-thumbnail/) for more examples.

## Configuration

Publish the configuration file with the following command.

```bash
php artisan vendor:publish --tag=thumbnail-config
```

The configuration file is located at `config/thumbnail.php`. Read [here](https://rolandstarke.github.io/laravel-thumbnail/configuration.html) what you can configure.

## Commands

Deletes the generated thumbnails.

```bash
php artisan thumbnail:purge
```

## Tests

```php
php vendor/bin/phpunit
```

## License

[MIT](LICENSE)
