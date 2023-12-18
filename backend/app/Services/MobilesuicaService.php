<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\MobilesuicaRepository;
use DiDom\Document;

enum MobilesuicaState: string
{
    case CAPTCHA = 'CAPTCHA';
    case LOGIN = 'LOGIN';
}

class MobilesuicaFormParams
{
    protected readonly string $__EVENTARGUMENT;

    protected readonly string $__EVENTTARGET;

    protected readonly string $__VIEWSTATE;

    protected readonly string $__VIEWSTATEENCRYPTED;

    protected readonly string $__VIEWSTATEGENERATOR;

    protected readonly string $baseVariable;

    protected readonly string $baseVarLogoutBtn;

    protected readonly string $LOGIN;

    protected readonly string $MailAddress;

    protected readonly string $Password;

    protected readonly string $WebCaptcha1__editor;

    protected readonly string $WebCaptcha1__editor_clientState;

    protected readonly string $WebCaptcha1_clientState;

    public function __construct(array $params = [])
    {
        $reflect = new \ReflectionClass($this);

        $props = $reflect->getProperties();

        foreach ($props as $prop) {
            $name = $prop->getName();

            if (array_key_exists($name, $params)) {
                $this->{$name} = $params[$name];
            }
        }
    }

    public function set(Document $document): static
    {
        foreach ([
            '__EVENTARGUMENT',
            '__EVENTTARGET',
            '__VIEWSTATE',
            '__VIEWSTATEENCRYPTED',
            '__VIEWSTATEGENERATOR',
            'baseVariable',
        ] as $name) {
            $this->{$name} = $document->first("input[name='{$name}']")?->getAttribute('value') ?? '';
        }

        $this->baseVarLogoutBtn = 'off';
        $this->LOGIN = 'ログイン';
        $this->WebCaptcha1_clientState = '[[[[null]],[],[]],[{},[]],null]';

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

class MobilesuicaService
{
    public function __construct(protected MobilesuicaRepository $repository) {}

    public function fetchCaptcha(): string
    {
        $html = $this->repository->fetchHtml();

        $document = new Document($html);

        $captchaUri = $document->first('.igc_TrendyCaptchaImage')?->getAttribute('src');

        if ($captchaUri === null) {
            throw new \Exception('Captcha not found');
        }

        $mobilesuicaFormParams = new MobilesuicaFormParams();

        $mobilesuicaFormParams->set($document);

        $captcha = $this->repository->downloadCaptcha($captchaUri);

        $this->repository->saveCookie(MobilesuicaState::CAPTCHA);
        $this->repository->saveFormParams($mobilesuicaFormParams);

        return $captcha;
    }

    public function auth(): array
    {
        $mobilesuicaFormParams = $this->repository->getFormParams();

        var_dump($mobilesuicaFormParams);

        return [];
    }
}
