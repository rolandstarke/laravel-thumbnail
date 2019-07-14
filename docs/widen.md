---
layout: default
title: Thumbnail::widen
---

# Thumbnail::widen

## Description

```php
public Thmbnail::widen( int $width ): self
```

Resizes the current image to new **width**, constraining aspect ratio.

## Paremeters

### width

The new width of the image

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('/cat.jpg', 'public')->widen(100)->url() }}">

<?php
    //inside config/thumbnail.php
    'widen' => '100',
{% endraw  %} ```
