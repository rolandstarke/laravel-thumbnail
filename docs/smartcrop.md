---
layout: default
title: Thumbnail::smartcrop
---

# Thumbnail::smartcrop

## Description

```php
public Thmbnail::smartcrop( int $width, int $height ): self
```

Tries to find a good Crop in the given dimensions. With the help of [smartcrop.js](https://github.com/jwagner/smartcrop.js/){:target="_blank"}

## Paremeters

### width

The width the image will be resized to.

### height

The height the image will be resized to.

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('cat.jpg', 'public')->smartcrop(64, 64)->url() }}">

<?php
    //inside config/thumbnail.php
    'smartcrop' => '64x64',
{% endraw  %} ```
