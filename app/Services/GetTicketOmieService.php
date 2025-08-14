<?php

namespace App\Services;

use App\Models\GetTicket;
use App\Services\OmieApiService;
use Exception;

class GetTicketOmieService
{
    protected $omieApi;

    public function __construct(OmieApiService $omieApi)
    {
        $this->omieApi = $omieApi;
    }

    public function salvarBoletoDisponivel(string $codigoTitulo, string $codigoIntTitulo)
    {
        try {
            // Chama a API para listar os clientes
            $response = $this->omieApi->obterBoletos($codigoTitulo, $codigoIntTitulo);
            
            GetTicket::updateOrCreate(
                ['codigo_titulo' => $response['codigo_titulo']], // Se já existir, será atualizado
                [
                    'codigo_int_titulo' => $response['codigo_int_titulo'],
                    'codigo_titulo' => $response['codigo_titulo'],
                    'codigo_status'=> $response['codigo_status'],
                    'data_emissao_boleto' => $response['data_emissao_boleto'],
                    'numero_boleto' => $response['numero_boleto'],
                    'codigo_barras' => $response['codigo_barras'],
                    'link_boleto' => $response['link_boleto']
                ]
            );
           

            return response()->json(['message' => 'Link de Boleto salvo com sucesso!']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao salvar link de boleto: ' . $e->getMessage()], 500);
        }
    }
}
