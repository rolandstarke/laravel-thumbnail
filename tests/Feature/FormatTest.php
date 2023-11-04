<?php

namespace Rolandstarke\Thumbnail\Tests\Feature;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FormatTest extends TestCase
{
    const TEST_IMAGE = 'test-images/cat.jpg';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = require(__DIR__ . '/../../config/thumbnail.php');
        $config['presets']['test'] = [
            'destination' => ['disk' => 'public', 'path' => 'tests/feature/format/cache/'],
        ];
        $app['config']->set('thumbnail', $config);
    }

    public function testJpegInJpegOut()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->format('jpeg')
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        Storage::disk('public')->put('tests/feature/format/' . __FUNCTION__ . '.jpg', $response->getContent());
    }

    public function testJpegQuality()
    {
        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->format('jpeg', 95)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        Image::make($response->getContent());

        Storage::disk('public')->put('tests/feature/format/' . __FUNCTION__ . '_good.jpg', $response->getContent());

        $goodImageSize = strlen($response->getContent());

        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->format('jpeg', 10)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        Storage::disk('public')->put('tests/feature/format/' . __FUNCTION__ . '_bad.jpg', $response->getContent());

        $badImageSize = strlen($response->getContent());


        $this->assertGreaterThan($badImageSize, $goodImageSize);
    }
}
