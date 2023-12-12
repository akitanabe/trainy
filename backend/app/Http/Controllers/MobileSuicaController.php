<?php

namespace App\Http\Controllers;

use App\Services\MobileSuicaService;

class MobileSuicaController extends Controller
{
    public function __construct(protected MobileSuicaService $service)
    {
    }

    public function captcha()
    {
        $this->service->fetchCaptcha();
    }
}
