---
layout: default
title: Thumbnail::save
---

# Thumbnail::save

## Description

```php
 public Thumbnail::save( void ): self
```

Generates the Thumbnail and stores it in the configured destination.

## Paremeters

none

## Return Values

Returns the `RolandStarke\Thumbnail\Thumbnail` object for method chaining.

## Examples

```php {% raw  %}
<?php
    \Thumbnail::src('/cat.jpg', 'public')->save();
{% endraw  %} ```
