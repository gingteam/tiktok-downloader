<?php

namespace TikTok;

use TikTok\Driver\DriverInterface;
use TikTok\Driver\NativeDriver;

class VideoDownloader
{
    private DriverInterface $driver;

    public function __construct(DriverInterface $driver = null)
    {
        $this->driver = $driver ?? new NativeDriver();
    }

    public function setDriver(DriverInterface $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function get(string $url): string
    {
        return $this->driver->handle($url);
    }
}
