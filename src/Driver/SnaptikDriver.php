<?php

namespace TikTok\Driver;

use Goutte\Client;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SnaptikDriver implements DriverInterface
{
    public const CDN_URL = 'https://tikcdn.net/file/';

    public const PARAM_REGEX = '/\("([a-zA-Z]+)",[0-9]+,"([a-zA-Z]+)",([0-9]+),([0-9]+),[0-9]+\)/';

    public const TOKEN_REGEX = '/token=([a-zA-Z0-9]+)/';

    private Client $client;

    public function __construct(HttpClientInterface $client = null)
    {
        $this->client = new Client($client);
    }

    public function getVideo(string $url): string
    {
        $form = $this->client
            ->request('GET', 'https://snaptik.app/vn')
            ->filter('form')
            ->form()
            ->setValues(['url' => $url]);

        $html = $this->client->submit($form)->html();
        $token = $this->extractToken($html);

        if (!$token) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        return self::CDN_URL.$token.'.mp4';
    }

    /**
     * @return string|false
     */
    private function extractToken(string $html)
    {
        if (!preg_match(self::PARAM_REGEX, $html, $matches)) {
            return false;
        }
        array_shift($matches);

        /** @var array{0:string,1:string,2:int,3:int} $matches */
        [$h, $n, $t, $e] = $matches;

        $r = '';
        for ($i = 0, $len = strlen($h); $i < $len; ++$i) {
            $s = '';
            while ($h[$i] !== $n[$e]) {
                $s .= $h[$i];
                ++$i;
            }
            for ($j = 0; $j < strlen($n); ++$j) {
                $s = str_replace($n[$j], (string) $j, $s);
            }
            $r .= chr((int) ((int)base_convert($s, $e, 10) - $t));
        }

        preg_match(self::TOKEN_REGEX, $r, $matches);

        return array_pop($matches);
    }
}
