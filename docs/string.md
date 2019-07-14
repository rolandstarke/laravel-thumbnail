---
layout: default
title: Thumbnail::string
---

# Thumbnail::string

## Description

```php
 public Thumbnail::string( void ): string
```

Generates the Thumbnail and returns the binary data as a string.

## Paremeters

none

## Return Values

String representation of image.

## Examples

```php {% raw  %}
<?php
    $data = \Thumbnail::src('/cat.jpg', 'public')->string();
    file_put_contents('mycat.jpg', $data);
{% endraw  %} ```
