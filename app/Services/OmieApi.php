<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OmieApi
{
    protected string $api_url;
    protected string $app_key;
    protected string $app_secret;

    public function __construct()
    {
        $this->api_url    = config('services.omie_api.api_url');   // ex: https://app.omie.com.br/api/v1/financas/contareceber/
        $this->app_key    = config('services.omie_api.app_key');
        $this->app_secret = config('services.omie_api.app_secret');
    }

    protected function client()
    {
        return Http::baseUrl($this->api_url)  // << usar a URL, não a key
            ->timeout(15)
            ->retry(3, 200)
            ->acceptJson(); // Http já envia JSON por padrão quando passamos array
    }

    /**
     * Lista contas a receber na Omie.
     * @param int    $pagina
     * @param int    $porPagina
     * @param string $apenasImportadoApi 'S' ou 'N'
     * @param array  $filtrosExtras      filtros opcionais aceitos pela Omie (ex.: dt_inicio, dt_fim, etc.)
     */
    
    public function listarContasReceber(
        int $pagina = 1,
        int $porPagina = 20,
        string $apenasImportadoApi = 'N',
        array $filtrosExtras = []
    ) {
        $param = array_merge([
            "pagina"               => $pagina,
            "registros_por_pagina" => $porPagina,
            "apenas_importado_api" => $apenasImportadoApi
        ], $filtrosExtras);

        $payload = [
            "call"       => "ListarContasReceber",
            "app_key"    => $this->app_key,
            "app_secret" => $this->app_secret,
            "param"      => [ $param ] // << precisa ser array de 1 objeto
        ];

        // Se api_url já é o endpoint completo, pode usar post('') com baseUrl
        $response = $this->client()->post('', $payload)->throw();

        return $response->json();
    }
}
