<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use Symfony\Component\HttpFoundation\Response;

abstract class Service
{
    use ProvidesConvenienceMethods;
}
