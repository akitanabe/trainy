<?php

namespace App\Services;

use App\Repositories\MobileSuicaRepository;

class MobileSuicaService
{
    public function __construct(protected MobileSuicaRepository $repository)
    {
    }

    public function fetchCaptcha()
    {
        var_dump($this->repository);
    }
}
