<?php

namespace Rolandstarke\Thumbnail\Http\Controller;

use Illuminate\Http\Request;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Illuminate\Routing\Controller;

class ImageController extends Controller
{
    public function index(Request $request, $file, $preset)
    {
        
        try {
            $thumbnail = Thumbnail::preset($preset)
                ->setParamsFromUrl($request->query());
            if (!$thumbnail->isValidRequest($file)) {
                throw new \Exception('Invalid Request');
            };
        } catch (\Exception $err) {
            return response('Invalid Request', 400);
        }
        
        return $thumbnail->save()->response();
    }
}
