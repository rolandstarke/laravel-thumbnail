---
layout: default
title: Thumbnail::crop
---

# Thumbnail::crop

## Description

```php
public Thmbnail::crop( int $width, int $height ): self
```

Crops the image in the given dimensions at the center.

## Paremeters

### width

The width the image will be resized to.

### height

The height the image will be resized to.

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('/cat.jpg', 'public')->crop(64, 64)->url() }}">

<?php
    //inside config/thumbnail.php
    'crop' => '64x64',
{% endraw  %} ```
