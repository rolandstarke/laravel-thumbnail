---
layout: default
title: Thumbnail::string
---

# Thumbnail::string

## Description

```php
public Thumbnail::string( [ bool $useExisting = TRUE ] ): string
```

Generates the Thumbnail and returns the binary data as a string.

## Paremeters

### useExisting

When **TRUE** load the existing thumbnail, when **FALSE** generate new thumbnail from source image.

## Return Values

String representation of image.

## Examples

```php {% raw  %}
<?php
    $data = \Thumbnail::src('cat.jpg', 'public')->string();
    file_put_contents('mycat.jpg', $data);
{% endraw  %} ```
