<?php

declare(strict_types=1);

namespace App\Repositories;

use GuzzleHttp\Client;

enum MobilesuicaState: string
{
    case CAPTCHA = 'CAPTCHA';
    case LOGIN = 'LOGIN';
}

readonly class MobilesuicaRepository
{
    protected const BASE_URL = 'https://www.mobilesuica.com';

    protected const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

    protected readonly Client $client;

    public function __construct()
    {
        $jar = new \GuzzleHttp\Cookie\CookieJar();

        $this->client = new Client([
            'cookies' => $jar,
            'headers' => [
                'User-Agent' => self::USER_AGENT,
            ],
        ]);
    }

    /**
     * @return string;
     */
    public function fetchHtml(string $uri = ''): string
    {
        $url = self::BASE_URL . '/' . ltrim($uri, '/');

        $res = $this->client->request('GET', $url);

        return mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'SJIS-win');
    }

    public function downloadCaptcha(string $captchaUri): string
    {
        $url = self::BASE_URL . '/' . ltrim($captchaUri, '/');

        $res = $this->client->request('GET', $url);

        return $res->getBody()->getContents();
    }
}
