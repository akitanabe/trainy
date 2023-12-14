<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\MobileSuicaRepository;
use DiDom\Document;

class MobilesuicaService
{
    public function __construct(protected MobilesuicaRepository $repository) {}

    public function fetchCaptcha()
    {
        $html = $this->repository->fetchHtml();

        $document = new Document($html);

        $captchaUri = $document->first('.igc_TrendyCaptchaImage')?->getAttribute('src');

        if ($captchaUri === null) {
            throw new \Exception('Captcha not found');
        }

        return $this->repository->downloadCaptcha($captchaUri);
    }
}
