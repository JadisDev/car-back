<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;
use Symfony\Component\HttpFoundation\Response;

abstract class Service
{
    use ProvidesConvenienceMethods;

    private function response(array $data, $status) : JsonResponse {
        return response()->json(['data' => $data, 'status'=> $status], $status);
    }

    public function responseCreat(array $data) : JsonResponse {
        return $this->response($data, Response::HTTP_CREATED);
    }

    public function responseErro(string $message = 'Erro inesperado') : JsonResponse {
        return $this->response([$message], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
