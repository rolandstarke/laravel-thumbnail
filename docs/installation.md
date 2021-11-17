---
layout: default
title: Installation
---

# Installation

## Requirements

- GD Library or Imagick
- PHP >= 7.1.3
- Laravel >= 5.5

*For Ubuntu you can install the GD Graphics Library with:*

```bash
sudo apt install php-gd
```

Check that your `APP_URL` in `.env` is set correctly. (If you use `php artisan serve` make sure to add the port like `http://localhost:8000` else the images will not load.)

## Composer Installation

To install the most recent version, run the following command.

```bash
composer require rolandstarke/laravel-thumbnail
```
