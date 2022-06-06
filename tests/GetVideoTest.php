<?php

use PHPUnit\Framework\TestCase;
use TikTok\TikTokDownloader;

test('get video', function () {
    /** @var TestCase $this */
    $video = new TikTokDownloader();
    $this->assertIsString($video->getVideo('https://www.tiktok.com/@tiin.vn/video/7106079259537591554?is_copy_url=1&is_from_webapp=v1'));
});
