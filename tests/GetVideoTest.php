<?php

use PHPUnit\Framework\TestCase;
use TikTok\Driver\SnaptikDriver;
use TikTok\VideoDownloader;

test('get video', function () {
    /** @var TestCase $this */
    $video = new VideoDownloader();
    $this->assertIsString($video->get('https://www.tiktok.com/@tiin.vn/video/7106079259537591554?is_copy_url=1&is_from_webapp=v1'));
    $video->setDriver(new SnaptikDriver());
    $this->assertIsString($video->get('https://www.tiktok.com/@tiin.vn/video/7106079259537591554?is_copy_url=1&is_from_webapp=v1'));
});
