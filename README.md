<img src="https://i.imgur.com/OyY198O.png" width="200px" align="right">

# TikTok Downloader

[![test](https://github.com/gingteam/tiktok-downloader/actions/workflows/ci.yml/badge.svg)](https://github.com/gingteam/tiktok-downloader/actions/workflows/ci.yml)

## Installation

```bash
composer require gingteam/tiktok:dev-main
```


## Usage

```php
<?php

use TikTok\Driver\SnaptikDriver;
use TikTok\VideoDownloader;

require __DIR__.'/vendor/autoload.php';

$tiktok = new VideoDownloader(new SnaptikDriver());

echo $tiktok->get('https://www.tiktok.com/@philandmore/video/6805867805452324102');
```
