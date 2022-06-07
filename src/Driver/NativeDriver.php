<?php

namespace TikTok\Driver;

use Goutte\Client;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NativeDriver implements DriverInterface
{
    private Client $client;

    public function __construct(HttpClientInterface $client = null)
    {
        $this->client = new Client($client);
    }

    public function getVideo(string $url): string
    {
        $crawler = $this->client->request('GET', $url);

        $filter = $crawler->filter('#SIGI_STATE');
        if (0 === $filter->count()) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        $json = $filter->innerText();

        /** @var array{ItemModule:array<array{video:array{playAddr:string}}>} */
        $data = json_decode($json, true);
        $video = array_pop($data['ItemModule']);

        return $video['video']['playAddr'];
    }
}
