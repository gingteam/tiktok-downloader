<?php

namespace TikTok\Driver;

use Goutte\Client;
use Peast\Peast;
use Peast\Syntax\Node\Literal;
use Peast\Syntax\Node\StringLiteral;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FacebookDriver implements DriverInterface
{
    private Client $client;

    public function __construct(HttpClientInterface $client = null)
    {
        $this->client = new Client($client);
    }

    public function getVideo(string $url): string
    {
        $form = $this->client
            ->request('GET', 'https://snapsave.app/vn')
            ->filter('form')
            ->form()
            ->setValues(['url' => $url]);

        $jsContent = $this->client->submit($form)
            ->filter('script')
            ->first()
            ->innerText();

        // May be a bug ;))
        if (\strlen($jsContent) < 1000) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        $crawler = new Crawler($this->extractContent($jsContent));

        return (string) $crawler->selectLink('Download')->attr('href');
    }

    private function extractContent(string $js): string
    {
        $ast = Peast::latest($js)->parse();

        /** @var array{0:string,1:int,2:string,3:int,4:int,5:int} $literal */
        $literal = array_map(function (Literal $node): string {
            return $node->getValue();
        }, (array) $ast->query('CallExpression > CallExpression > Literal')->getIterator());

        [$h, $_, $n, $t, $e, $_] = $literal;

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
            $r .= chr((int) ((int) base_convert($s, $e, 10) - $t));
        }

        $ast = Peast::latest($r)->parse();

        /** @var StringLiteral */
        $node = $ast->query('Literal[value^="<"]')->get(0);

        return $node->getValue();
    }
}
