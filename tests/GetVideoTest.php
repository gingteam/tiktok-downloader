<?php

use PHPUnit\Framework\TestCase;
use TikTok\Driver\FacebookDriver;
use TikTok\Driver\SnaptikDriver;
use TikTok\VideoDownloader;
use function PHPUnit\Framework\assertIsString;

test('get video', function () {
    $video = new VideoDownloader(new SnaptikDriver());
    expect($video->get('https://www.tiktok.com/@tiin.vn/video/7106079259537591554?is_copy_url=1&is_from_webapp=v1'))->toBeString();
    $video->setDriver(new FacebookDriver());
    expect($video->get('https://www.facebook.com/watch/?v=343380744781609'))->toBeString();
    expect($video->get('https://www.facebook.com/watch/?v=343380744781601'))->toBeFalse();
});
