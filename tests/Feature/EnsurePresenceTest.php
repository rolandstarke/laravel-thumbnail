<?php

namespace Rolandstarke\Thumbnail\Tests\Feature;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EnsurePresenceTest extends TestCase
{

    const TEST_IMAGE = 'test-images/desert.jpg';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = require(__DIR__ . '/../../config/thumbnail.php');
        $config['presets']['test'] = [
            'destination' => ['disk' => 'public', 'path' => 'tests/feature/ensure-presence/cache/'],
        ];
        $app['config']->set('thumbnail', $config);
    }

    public function testShouldGenerateImageWithoutCallingUrlImage()
    {
        Storage::disk('public')->deleteDirectory('tests/feature/ensure-presence/cache/');

        Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->crop(60, 50)
            ->url(true);

        $files = Storage::disk('public')->allFiles('tests/feature/ensure-presence/cache/');
        $this->assertCount(1, $files);

        $image = Image::make(Storage::disk('public')->get($files[0]));

        $this->assertEquals(60, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());

    }

}


