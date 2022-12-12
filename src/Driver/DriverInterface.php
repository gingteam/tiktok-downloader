<?php

namespace TikTok\Driver;

interface DriverInterface
{
    public function handle(string $url): string;
}
