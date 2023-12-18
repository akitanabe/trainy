<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Services\MobilesuicaFormParams;
use App\Services\MobilesuicaState;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

readonly class MobilesuicaRepository
{
    protected const SESSION_KEY = 'MOBILESUICA_STATE';

    protected const BASE_URL = 'https://www.mobilesuica.com';

    protected const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

    protected readonly Client $client;

    protected readonly CookieJar $cookieJar;

    public function __construct()
    {
        $this->cookieJar = new CookieJar();

        $this->client = new Client([
            'cookies' => $this->cookieJar,
            'headers' => [
                'User-Agent' => self::USER_AGENT,
            ],
        ]);
    }

    /**
     * @param string $uri
     *
     * @return string;
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function fetchHtml(string $uri = '', ?MobilesuicaState $state = null): string
    {
        $url = self::BASE_URL . '/' . ltrim($uri, '/');
        $domain = parse_url(self::BASE_URL, PHP_URL_HOST);

        if ($state !== null && is_string($domain)) {
            $cookies = $this->getCookie($state);

            foreach ($cookies as $cookie) {
                $this->cookieJar->fromArray($cookie, $domain);
            }
        }

        $res = $this->client->request('GET', $url);

        return mb_convert_encoding($res->getBody()->getContents(), 'UTF-8', 'SJIS-win');
    }

    /**
     * @param string $captchaUri
     * @return string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadCaptcha(string $captchaUri = ''): string
    {
        $url = self::BASE_URL . '/' . ltrim($captchaUri, '/');

        $res = $this->client->request('GET', $url);

        return $res->getBody()->getContents();
    }

    public function saveFormParams(MobilesuicaFormParams $mobilesuicaFormParams): void
    {
        session_start();

        $_SESSION[self::SESSION_KEY . '_FORM'] = $mobilesuicaFormParams->toArray();

        session_write_close();
    }

    public function getFormParams(): MobilesuicaFormParams
    {
        session_start();

        $formParams = $_SESSION[self::SESSION_KEY . '_FORM'] ?? [];

        session_write_close();

        return new MobilesuicaFormParams($formParams);
    }

    public function saveCookie(MobilesuicaState $state): void
    {
        session_start();

        $_SESSION[self::SESSION_KEY . "_{$state->value}"] = $this->cookieJar->toArray();
        session_write_close();
    }

    public function getCookie(MobilesuicaState $state): array
    {
        session_start();

        $cookies = $_SESSION[self::SESSION_KEY . "_{$state->value}"] ?? [];

        session_write_close();

        return $cookies;
    }
}
