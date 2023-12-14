<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\MobilesuicaService;

class MobilesuicaController extends Controller
{
    public function __construct(protected MobilesuicaService $service) {}

    public function captcha()
    {
        $captcha = $this->service->fetchCaptcha();

        return response($captcha, 200, [
            'Content-Type' => 'image/gif',
        ]);
    }
}
