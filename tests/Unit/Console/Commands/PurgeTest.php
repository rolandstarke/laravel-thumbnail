<?php

namespace Rolandstarke\Thumbnail\Tests\Unit\Commands;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Thumbnail;
use Illuminate\Support\Facades\Storage;

class PurgeTest extends TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $config['presets']['test'] = [
            'destination' => ['disk' => 'public', 'path' => '/tests/unit/console/commands/purge'],
        ];
        $app['config']->set('thumbnail', $config);
    }

    public function testShouldCleanThumbnailDirectory()
    {
        Storage::disk('public')->put('/tests/unit/console/commands/purge/4517/4a56d435da479gs845.jpg', 'this file should be deleted');
        $this->assertNotEmpty(Storage::disk('public')->allFiles('/tests/unit/console/commands/purge'));

        $this->artisan('thumbnail:purge');
        $this->assertEmpty(Storage::disk('public')->allFiles('/tests/unit/console/commands/purge'));
    }

    public function testShouldNotCleanOtherDirectories()
    {
        $this->artisan('thumbnail:purge');
        $this->assertNotEmpty(Storage::disk('public')->allFiles('/test-images'));
    }

}
