<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OmieApiService
{
    // URL base da API Omie
    protected string $base_url;
    protected string $app_key;
    protected string $app_secret;

    public function __construct()
    {
        // Definindo URL base e chaves da API
        $this->base_url  = config('services.omie_api.api_omie_url');   // Exemplo: https://app.omie.com.br/api/v1
        $this->app_key   = config('services.omie_api.app_omie_key');
        $this->app_secret= config('services.omie_api.app_omie_secret');
    }

    /**
     * Retorna o client com a URL base e headers padrão
     */
    protected function client()
    {
        return Http::baseUrl($this->base_url)  // URL base
            ->timeout(15)
            ->retry(3, 200)
            ->acceptJson(); // Envia JSON por padrão
    }

    /**
     * Função genérica para realizar um POST na API
     * @param string $endpoint Endpoint adicional após a URL base
     * @param array $param Dados para o POST
     * @return array Resposta da API
     */
    protected function postToOmie(string $endpoint, array $param): array
    {
        $payload = [
            "call"       => $param['call'],
            "app_key"    => $this->app_key,
            "app_secret" => $this->app_secret,
            "param"      => $param['param'] // Omie exige um array de objetos
        ];
        
        // Realiza o POST para a URL completa (base_url + endpoint)
        $response = $this->client()->post($endpoint, $payload)->throw();
       
        return $response->json();
    }

    /**
     * Lista as contas a receber
     * @param string $apenasImportadoApi 'S' ou 'N'
     * @return array Dados da API
     */
    public function listarContasReceber(string $apenasImportadoApi = 'N') {
        $param = array_merge([
            "apenas_importado_api" => $apenasImportadoApi
        ]);

        return $this->postToOmie('financas/contareceber/', [
            'call' => 'ListarContasReceber',
            'param' => $param
        ]);
    }

    /**
     * Lista os clientes
     * @param string $apenasImportadoApi 'S' ou 'N'
     * @return array Dados da API
     */
    public function listarClientes(string $apenasImportadoApi = 'N') {
        $param = array_merge([
            "apenas_importado_api" => $apenasImportadoApi
        ]);
        
        return $this->postToOmie('geral/clientes/', [
            'call' => 'ListarClientes',
            'param' => [$param]
        ]);
    }

    /**
     * Obter boletos
     * @param string $nCodTitulo
     * @param string $cCodIntTitulo 
     * @return array Dados da API
     */
    public function obterBoletos(string $nCodTitulo, string $cCodIntTitulo = '') {
        $param = array_merge([
            "codigo_titulo" => $nCodTitulo,
            "codigo_int_titulo" => $cCodIntTitulo
        ]);
        
        return $this->postToOmie('financas/contareceberboleto/', [
            'call' => 'ObterBoleto',
            'param' => [$param]
        ]);
    }
}
