---
layout: default
title: Thumbnail::delete
---

# Thumbnail::delete

## Description

```php
public Thumbnail::delete( void ): self
```

Deletes the generated Thumbnail in the configured destination.

## Paremeters

none

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<?php
    \Thumbnail::src('/cat.jpg', 'public')->delete();
{% endraw  %} ```
