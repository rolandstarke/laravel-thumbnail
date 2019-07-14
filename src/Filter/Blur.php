<?php

namespace Rolandstarke\Thumbnail\Filter;

use Intervention\Image\Image;

class Blur implements FilterInterface
{
    public function handle(Image $image, array $params): Image
    {
        if (isset($params['blur']) && $params['blur'] > 0) {
            $image->blur($params['blur']);
        }
        return $image;
    }
}
