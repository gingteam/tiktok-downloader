<?php

namespace TikTok\Driver;

use TikTok\Concern\Crawlable;
use TikTok\Util\Token;

/**
 * @implements DriverInterface<string|false>
 */
class SnaptikDriver implements DriverInterface
{
    use Crawlable;

    public const CDN_URL = 'https://cdn.snaptik.app/v2';

    public function handle(string $url)
    {
        $browser = $this->getBrowser();

        $crawler = $browser
            ->request('GET', 'https://snaptik.app/vn')
            ->filter('form')
            ->first();

        /** @var \DOMElement */
        $el = $crawler->getNode(0);
        $el->setAttribute('action', '/abc2.php');
        $el->setAttribute('method', 'POST');

        $form = $crawler->form()->setValues(['url' => $url]);

        $browser->submit($form);

        /** @var \Symfony\Component\BrowserKit\Response */
        $response = $browser->getResponse();

        $token = Token::extract($response->getContent());

        return $token ? sprintf('%s/?token=%s&dl=1', self::CDN_URL, $token) : false;
    }
}
