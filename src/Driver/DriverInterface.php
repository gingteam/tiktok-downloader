<?php

namespace TikTok\Driver;

interface DriverInterface
{
    public function getVideo(string $url): string;
}
