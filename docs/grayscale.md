---
layout: default
title: Thumbnail::grayscale
---

# Thumbnail::grayscale

## Description

```php
public Thmbnail::grayscale( void ): self
```

Turns image into a greyscale version.

## Paremeters

none

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('cat.jpg', 'public')->grayscale()->url() }}">

<?php
    //inside config/thumbnail.php
    'grayscale' => '1',
{% endraw  %} ```
