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

        $captcha = $this->repository->downloadCaptcha($captchaUri);

        $this->repository->saveCookie(MobilesuicaState::CAPTCHA);

        return $captcha;
    }
}
