---
layout: default
title: Image crop library for Laravel
---

# Laravel Thumbnail

![image](assets/img/desert.jpg) ![image resized](assets/img/desert_resized.jpg)

```html {% raw  %}
<img src="{{ Storage::disk('public')->url('desert.jpg') }}">
<!-- <img src="/storage/desert.jpg"> -->

<img src="{{ Thumbnail::src('desert.jpg', 'public')->smartcrop(200, 200)->url() }}">
<!-- <img src="/storage/jhf47.jpg?src=desert.jpg&smartcrop=200x200"> -->
{% endraw  %} ```


Laravel package to resize images with specially formatted URLs. Uses [Intervention Image](http://image.intervention.io/){:target="_blank"} for image manipulation and  [smartcrop.js](https://github.com/jwagner/smartcrop.js/){:target="_blank"} to find optimal crop positions.

- Generates the URL without touching the filesystem.
- Rendered thumbnails are stored and subsequent requests are directly served from your nginx/apache.
- The URL is signed to prevent malicious parameters.
