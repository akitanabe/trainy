<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\MobilesuicaService;
use Illuminate\Http\Response;

class MobilesuicaController extends Controller
{
    public function __construct(protected MobilesuicaService $service) {}

    public function captcha(): Response
    {
        $captcha = $this->service->fetchCaptcha();

        return response($captcha, 200, [
            'Content-Type' => 'image/gif',
        ]);
    }
}
