---
layout: default
title: Thumbnail::preset
---

# Thumbnail::preset

## Description

```php
public Thumbnail::preset( string $preset ): self
```

The thumbnail will be generated with the configured preset.

## Paremeters

### preset

Name of the preset used in `config/thumbnail.php`.

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}

//inside config/thumbnail.php

    'presets' => [
        'avatar' => [
            'destination' => ['disk' => 'public', 'path' => '/thumbnails/avatar/'],
            'smartcrop' => '64x64',
        ],
    ],


//inside a blade file

    <img src="{{ Thumbnail::preset('avatar')->src('/cat.jpg', 'public')->url() }}">

    //the url will automaticaly have the param smartcrop=64x64
{% endraw  %} ```
