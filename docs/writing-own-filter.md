---
layout: default
title: Writing your own Filter
---

# Writing your own Filter

You can add your own filters. For example, we can create a filter that colors an image. To do that we create a class `Tint` that implements the `Rolandstarke\Thumbnail\Filter\FilterInterface`. You can place the file anywhere in your project. For this example we place it to `app/ImageFilters/Tint.php`.

```php
<?php

namespace App\ImageFilters;

use Intervention\Image\Image;
use Rolandstarke\Thumbnail\Filter\FilterInterface;


class Tint implements FilterInterface
{
    public function handle(Image $image, array $params): Image
    {
        //maimulate $image here
    }
}
```

The filter has a single method that accepts an Intervention image object and the params that where set for this thumbnail. It should return the modified image.

For the source image we use the following image and place it to `resources\images\empty_profile_transparent.png`.

<span class="transparnet-bg"><img src="assets/img/empty_profile_transparent.png"></span>


We will use an integer parameter tint from 1-10 where the number represent a predefined color and fills the background of the image with it.

```php
<?php
    public function handle(Image $image, array $params): Image
    {
        if (isset($params['tint'])) {
            $tints = [
                '#c2175b', '#00579c', '#7e57c2', '#00887a', '#465a65',
                '#7a1fa2', '#0288d1', '#c2175b', '#bf360c', '#689f39'
            ];
            if (isset($tints[$params['tint'] - 1])) {
                $newImage = clone $image;
                $newImage->fill($tints[$params['tint'] - 1]);
                $newImage->insert($image);
                return $newImage;
            }
        }
        return $image;
    }
```

We now need to add the filter in the config file `config/thumbnail.php`.

```php
<?php
    'filters' => [
        Rolandstarke\Thumbnail\Filter\Resize::class,
        //... 
        App\ImageFilters\Tint::class, //add this line
    ],
```

 The filter will now run for every generated thumbnail. You can set the tint param with the `param` method on the thumbnail class.

```php
<?php

echo \Thumbnail::src(resource_path('images/empty_profile_transparent.png'))
            ->param('tint', 1)
            ->crop(64, 64)
            ->url();
```

You will get images like:

![image](assets/img/tint1.png) ![image resized](assets/img/tint2.png)