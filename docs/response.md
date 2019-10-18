---
layout: default
title: Thumbnail::response
---

# Thumbnail::response

## Description

```php
public Thumbnail::response( [ bool $useExisting = TRUE ] ): Illuminate\Http\Response
```

Generates the Thumbnail and sends a HTTP response.

## Paremeters

### useExisting

When **TRUE** load the existing thumbnail, when **FALSE** generate new thumbnail from source image.


## Return Values

Illuminate\Http\Response with the corresponding header fields already set.

## Examples

```php {% raw  %}
<?php

Route::get('/', function() {
    return \Thumbnail::src('/cat.jpg', 'public')->response();
});
{% endraw  %} ```
