<?php

namespace TikTok\Concern;

use Symfony\Component\BrowserKit\HttpBrowser;

trait Crawlable
{
    public function getBrowser(): HttpBrowser
    {
        static $browser = null;
        if (null === $browser) {
            $browser = new HttpBrowser();
        }

        return $browser;
    }
}
