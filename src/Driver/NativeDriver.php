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

        if (0 === $crawler->filter('#SIGI_STATE')->count()) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        $json = $crawler->filter('#SIGI_STATE')->innerText();

        /** @var array{ItemModule:array<array{video:array{playAddr:string}}>} */
        $data = json_decode($json, true);
        $video = array_pop($data['ItemModule']);

        return $video['video']['playAddr'];
    }
}
