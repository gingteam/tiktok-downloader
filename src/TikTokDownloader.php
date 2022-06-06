<?php

namespace TikTok;

use TikTok\Driver\DriverInterface;
use TikTok\Driver\NativeDriver;

class TikTokDownloader
{
    private DriverInterface $driver;

    public function __construct(DriverInterface $driver = null)
    {
        $this->driver = $driver ?? new NativeDriver();
    }

    public function getVideo(string $url): string
    {
        return $this->driver->getVideo($url);
    }
}
