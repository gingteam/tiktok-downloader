<?php

namespace TikTok\Driver;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NativeDriver implements DriverInterface
{
    private HttpBrowser $client;

    public function __construct(HttpClientInterface $client = null)
    {
        $this->client = new HttpBrowser($client);
    }

    public function handle(string $url): string
    {
        $crawler = $this->client->request('GET', $url);

        $filter = $crawler->filter('#SIGI_STATE');
        if (0 === $filter->count()) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        $json = $filter->innerText();

        /** @var array{ItemModule:array<array{video:array{playAddr:string}}>} */
        $data = json_decode($json, true);
        $video = array_pop($data['ItemModule'])['video'];

        return $video['playAddr'];
    }
}
