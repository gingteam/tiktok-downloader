<?php

namespace TikTok\Driver;

interface DriverInterface
{
    /**
     * @return string|false Trả về `false` trong trường hợp thất bại
     */
    public function handle(string $url);
}
