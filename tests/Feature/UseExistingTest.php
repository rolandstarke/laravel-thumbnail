<?php

namespace Rolandstarke\Thumbnail\Tests\Feature;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UseExistingTest extends TestCase
{

    const TEST_IMAGE = 'test-images/desert.jpg';

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config = require(__DIR__ . '/../../config/thumbnail.php');
        $config['presets']['test'] = [
            'destination' => ['disk' => 'public', 'path' => 'tests/feature/use-existing/cache/'],
        ];
        $app['config']->set('thumbnail', $config);
    }

    public function testShouldCreateFileInDestination()
    {
        Storage::disk('public')->deleteDirectory('tests/feature/use-existing/cache/');

        $string = Thumbnail::preset('test')
            ->src(self::TEST_IMAGE, 'public')
            ->crop(60, 50)
            ->string(true);

        $image = Image::make($string);

        $this->assertEquals(60, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());


        $files = Storage::disk('public')->allFiles('tests/feature/use-existing/cache/');
        $this->assertCount(1, $files);

        $image = Image::make(Storage::disk('public')->get($files[0]));

        $this->assertEquals(60, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

    public function testShouldGiveImageAfterDeletingSource()
    {
        Storage::disk('public')->deleteDirectory('tests/feature/use-existing/cache/');

        Storage::disk('public')->put('tests/feature/use-existing/source-image.jpg', Storage::disk('public')->get(self::TEST_IMAGE));

        Thumbnail::preset('test')
            ->src('tests/feature/use-existing/source-image.jpg', 'public')
            ->crop(60, 50)
            ->string(true);

        Storage::disk('public')->delete('tests/feature/use-existing/source-image.jpg');

        $string = Thumbnail::preset('test')
            ->src('tests/feature/use-existing/source-image.jpg', 'public')
            ->crop(60, 50)
            ->string(true);

        $image = Image::make($string);

        $this->assertEquals(60, $image->getWidth());
        $this->assertEquals(50, $image->getHeight());
    }

}


