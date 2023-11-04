<?php

namespace Rolandstarke\Thumbnail\Tests\Unit;

use Rolandstarke\Thumbnail\Tests\TestCase;
use Rolandstarke\Thumbnail\Thumbnail;

class ThumbnailTest extends TestCase
{

    protected function getConfig()
    {
        return [
            'allowedSources' => [
                'http' => 'http',
                'disk' => ['disk' => 'public', 'path' => 'test-images/'],
                'dir' => public_path('test-images/')
            ],
            'presets' => [
                'default' => [
                    'destination' => ['disk' => 'public', 'path' => '/tests/unit/thumbnail/'],
                ],
            ]
        ];
    }

    public function testShouldWorkWithUrl()
    {
        $thumbnail = new Thumbnail($this->getConfig());
        $imageUrl = $thumbnail->src('http://example.com/image.jpeg')->url();

        $this->assertStringContainsString('example.com', $imageUrl);
    }

    public function testShouldWorkWithPath()
    {
        $thumbnail = new Thumbnail($this->getConfig());
        $imageUrl = $thumbnail->src(public_path('test-images/image.jpg'))->url();

        $this->assertStringContainsString('image.jpg', $imageUrl);
    }

    public function testShouldWorkWithDisk()
    {
        $thumbnail = new Thumbnail($this->getConfig());
        $imageUrl = $thumbnail->src('test-images/image.jpg', 'public')->url();

        $this->assertStringContainsString('image.jpg', $imageUrl);
    }

    public function testShouldSetParams()
    {
        $thumbnail = new Thumbnail($this->getConfig());
        $imageUrl = $thumbnail
            ->src('http://example.com/image.jpeg')
            ->param('testparam', 'testvalue')
            ->url();

        $this->assertStringContainsString('testparam=testvalue', $imageUrl);
    }

    public function testSameParamsShouldResultInSameUrl()
    {
        $thumbnail = new Thumbnail($this->getConfig());
        $imageUrl = $thumbnail
            ->src('http://example.com/image.jpeg')
            ->param('testparam', 1)->param('param2', 'q')
            ->url();

        $imageUrl2 = $thumbnail
            ->src('http://example.com/image.jpeg')
            ->param('param2', 'q')->param('testparam', '1')
            ->url();

        $this->assertEquals($imageUrl, $imageUrl2);
    }

    public function testShouldThrowExceptionUsingNotAllowedSource()
    {
        $this->expectException(\Exception::class);
        $thumbnail = new Thumbnail($this->getConfig());
        $imageUrl = $thumbnail->src('ftp://example.com/image.jpeg')->url();
    }

    public function testShouldThrowExeptionIfNoSourceIsSet()
    {
        $this->expectException(\Exception::class);
        $thumbnail = new Thumbnail($this->getConfig());
        $thumbnail->url();
    }

    public function testShouldThrowExeptionIfUnknownPresetIsUsed()
    {
        $this->expectException(\Exception::class);
        $thumbnail = new Thumbnail($this->getConfig());
        $thumbnail->preset('some not existing preset');
    }
}
