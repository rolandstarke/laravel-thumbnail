<?php

namespace Rolandstarke\Thumbnail\Filter;

use Intervention\Image\Image;

class Greyscale implements FilterInterface
{
    public function handle(Image $image, array $params): Image
    {
        if (isset($params['greyscale']) && $params['greyscale'] === '1') {
            $image->greyscale();
        }
        return $image;
    }
}
