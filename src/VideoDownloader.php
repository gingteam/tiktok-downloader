<?php

namespace TikTok;

use TikTok\Driver\DriverInterface;

/**
 * @template T
 */
class VideoDownloader
{
    /**
     * @var DriverInterface<T>
     */
    private DriverInterface $driver;

    /**
     * @param DriverInterface<T> $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param DriverInterface<T> $driver
     *
     * @return VideoDownloader<T>
     */
    public function setDriver(DriverInterface $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return T
     */
    public function get(string $url)
    {
        return $this->driver->handle($url);
    }
}
