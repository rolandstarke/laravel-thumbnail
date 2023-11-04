<?php

namespace Rolandstarke\Thumbnail\Tests\Feature;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FacadeTest extends TestCase
{

    const TEST_IMAGE = 'test-images/desert.jpg';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = require(__DIR__ . '/../../config/thumbnail.php');
        $config['presets']['test'] = [
            'destination' => ['disk' => 'public', 'path' => 'tests/feature/facade/cache/'],
        ];
        $app['config']->set('thumbnail', $config);
    }

    public function testMultibleCallsShouldNotShareSettings()
    {

        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->heighten(30)
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        $this->assertEquals(30, $image->getHeight());



        $url = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->url();
        $response = $this->call('GET', $url);
        $response->assertSuccessful();

        $image = Image::make($response->getContent());

        $this->assertNotEquals(30, $image->getHeight());
    }
}
