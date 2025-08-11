<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OmieApi
{
    protected string $app_key;
    protected string $app_secret;

    public function __construct()
    {
        $this->app_key  = config('services.omie_api.app_key');
        $this->app_secret = config('services.omie_api.app_secret');
    }

    protected function client()
    {
        return Http::baseUrl($this->app_key)
            ->timeout(15)
            ->retry(3, 200) // 3 tentativas, espera 200ms
            ->withToken($this->app_secret) // Bearer <token>
            ->acceptJson();           // Header Accept: application/json
    }

    public function listarContasReceber(array $filtros = [])
    {
        // GET /users?status=active&page=1
        $res = $this->client()->get('/api/v1/financas/contareceber', $filtros);

        $res->throw(); // lança exceção se 4xx/5xx

        return $res->json(); // array
    }
}
