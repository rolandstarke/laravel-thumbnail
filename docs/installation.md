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
#php 7.1
sudo apt-get install php7.1-gd

#php 7.2
sudo apt-get install php7.2-gd

#php 7.3
sudo apt-get install php7.3-gd
```

Check that your `APP_URL` in `.env` is set correctly.

## Composer Installation

To install the most recent version, run the following command.

```bash
composer require rolandstarke/laravel-thumbnail
```
