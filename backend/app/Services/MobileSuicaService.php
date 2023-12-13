<?php

namespace App\Services;

use App\Repositories\MobileSuicaRepository;
use DiDom\Document;

class MobileSuicaService
{
    public function __construct(protected MobileSuicaRepository $repository)
    {
    }

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
