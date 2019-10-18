---
layout: default
title: Thumbnail::format
---

# Thumbnail::format

## Description

```php
public Thmbnail::format( string $format [, int $quality = NULL ] ): self
```

Sets the output format and quality. By default the source format is used.

## Paremeters

### format

Define the encoding format from one of the following formats **jpg**, **png**, **gif** and **webp**.

### quality

Define the quality of the encoded image optionally. Data ranging from 0 (poor quality, small file) to 100 (best quality, big file). Quality is only applied if you're encoding JPG format since PNG compression is lossless and does not affect image quality. Default: 90.

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('/cat.jpg', 'public')->format('png')->url() }}">

<?php
    //inside config/thumbnail.php
    'format' => 'jpg',
    'quality' => '90',
{% endraw  %} ```
