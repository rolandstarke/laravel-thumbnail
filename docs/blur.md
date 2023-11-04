---
layout: default
title: Thumbnail::blur
---

# Thumbnail::blur

## Description

```php
public Thmbnail::blur( [ int $amount = 1 ] ): self
```

Apply a gaussian blur filter with a optional amount on the current image. Use values between 0 and 100.

**Note: Performance intensive on larger amounts of blur with GD driver. Use with care.**

## Paremeters

### amout

The amount of the blur strength. Use values between 0 and 100. Default: 1

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('cat.jpg', 'public')->blur(1)->url() }}">

<img src="{{ Thumbnail::src('cat.jpg', 'public')->blur(10)->url() }}">

<img src="{{ Thumbnail::src('cat.jpg', 'public')->blur(50)->url() }}">

<?php
    //inside config/thumbnail.php
    'blur' => '1',
{% endraw  %} ```
