<?php

namespace Rolandstarke\Thumbnail\Tests\Feature;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FilterTest extends TestCase
{

    const TEST_IMAGE = 'test-images/desert.jpg';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = require(__DIR__ . '/../../config/thumbnail.php');
        $config['presets']['test'] = [
            'destination' => ['disk' => 'public', 'path' => 'tests/feature/filter/cache/'],
        ];
        $app['config']->set('thumbnail', $config);
    }

    public function testShouldCropImage()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->crop(60, 50)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        $this->assertEquals(60, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());

        Storage::disk('public')->put('tests/feature/filter/' . __FUNCTION__ . '.jpg', $response->getContent());
    }

    public function testShouldSmartcropImage()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->smartcrop(200, 200)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        $this->assertEquals(200, $image->getWidth());
        $this->assertEquals(200, $image->getHeight());

        Storage::disk('public')->put('tests/feature/filter/' . __FUNCTION__ . '.jpg', $response->getContent());
    }

    public function testShouldBlurImage()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->blur(1)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        Storage::disk('public')->put('tests/feature/filter/' . __FUNCTION__ . '.jpg', $response->getContent());
    }

    public function testShouldGreyscaleImage()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->greyscale()
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        Storage::disk('public')->put('tests/feature/filter/' . __FUNCTION__ . '.jpg', $response->getContent());
    }

    public function testShouldWidenImage()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->widen(30)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        $this->assertEquals(30, $image->getWidth());

        Storage::disk('public')->put('tests/feature/filter/' . __FUNCTION__ . '.jpg', $response->getContent());

    }

    public function testShouldHeightenImage()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->heighten(30)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        $this->assertEquals(30, $image->getHeight());

        Storage::disk('public')->put('tests/feature/filter/' . __FUNCTION__ . '.jpg', $response->getContent());
    }
}


