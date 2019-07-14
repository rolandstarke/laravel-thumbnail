---
layout: default
title: Thumbnail::response
---

# Thumbnail::response

## Description

```php
 public Thumbnail::response( void ): Illuminate\Http\Response
```

Generates the Thumbnail and sends a HTTP response.

## Paremeters

none

## Return Values

Illuminate\Http\Response with the corresponding header fields already set.

## Examples

```php {% raw  %}
<?php

Route::get('/', function() {
    return \Thumbnail::src('/cat.jpg', 'public')->response();
});
{% endraw  %} ```
