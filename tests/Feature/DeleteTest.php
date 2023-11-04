<?php

namespace Rolandstarke\Thumbnail\Tests\Feature;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class DeleteTest extends TestCase
{

    const TEST_IMAGE = 'test-images/desert.jpg';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = require(__DIR__ . '/../../config/thumbnail.php');
        $config['presets']['test'] = [
            'destination' => ['disk' => 'public', 'path' => 'tests/feature/delete/cache/'],
        ];
        $app['config']->set('thumbnail', $config);
    }

    public function testShouldDeleteFileInDestination()
    {
        Storage::disk('public')->deleteDirectory('tests/feature/delete/cache');

        Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->crop(60, 50)
            ->save();

        $files = Storage::disk('public')->allFiles('tests/feature/delete/cache');
        $this->assertCount(1, $files);

        Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->crop(60, 50)
            ->delete();

        $files = Storage::disk('public')->allFiles('tests/feature/delete/cache');
        $this->assertCount(0, $files);
    }
}
