---
layout: default
title: Thumbnail::heigthen
---

# Thumbnail::heigthen

## Description

```php
public Thmbnail::heigthen( int $height ): self
```

Resizes the current image to new **height**, constraining aspect ratio.

## Paremeters

### height

The new height of the image

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('/cat.jpg', 'public')->heigthen(100)->url() }}">

<?php
    //inside config/thumbnail.php
    'heigthen' => '100',
{% endraw  %} ```
