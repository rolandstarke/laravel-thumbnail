---
layout: default
title: Thumbnail::src
---

# Thumbnail::src

## Description

```php
 public Thumbnail::src( string $path [, string $disk = null] ): self
```

Sets the source image.

## Paremeters

### path

Absolute path of the source image.

### disk

The [filesystem](https://laravel.com/docs/filesystem){:target="_blank"} diskname to load the image from. If not set will loead the file without laravels filesystem.

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('/cat.jpg', 'public')->smartcrop(64, 64)->url() }}">

<?php

//load from path
echo \Thumbnail::src('/path/to/file.jpg')->url();

//load from website
echo \Thumbnail::src('https://laravel.com/favicon.png')->url();

//load from laravels pubic directory
echo \Thumbnail::src(public_path('favicon.png'))->url();

//load from Storage::disk('local')->get('user1.png')
echo \Thumbnail::src('user1.jpg', 'local')->url();

{% endraw  %} ```
