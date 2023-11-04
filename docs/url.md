---
layout: default
title: Thumbnail::url
---

# Thumbnail::url

## Description

```php
public Thumbnail::url( [ bool $ensurePresence = FALSE ] ): string
```

Generates the signed URL for the thumbnail with all the params previously set.

## Paremeters

### ensurePresence

When **TRUE** check if the thumbnail exists and generate it if needed.


## Return Values

URL to the thumbnail.

## Examples

```php {% raw  %}
<img src="{{ Thumbnail::src('cat.jpg', 'public')->url() }}">

<?php

echo \Thumbnail::src('cat.jpg', 'public')->url();
// http:localhost:8000/storage/thumbnails/default/87tg/jh2tydgkc80skg88sokwc.jpg?p=cat.jpg&s=pd
{% endraw  %} ```
