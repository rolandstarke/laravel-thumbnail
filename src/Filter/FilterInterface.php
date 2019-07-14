<?php

namespace Rolandstarke\Thumbnail\Filter;

use Intervention\Image\Image;

interface FilterInterface
{
    function handle(Image $image, array $params): Image;

}
