<?php

namespace App\Services;

use App\Models\GetTicket;
use App\Models\CustomerReceive;
use App\Services\OmieApiService;
use Exception;

class GetTicketOmieService
{
    protected $omieApi;

    public function __construct(OmieApiService $omieApi)
    {
        $this->omieApi = $omieApi;
    }

    public function chamarBoleto()
    {
        $codigoLancamentoOmie = CustomerReceive::pluck('codigo_lancamento_omie')->toArray();

        foreach ($codigoLancamentoOmie as $codigo) {
            $this->salvarBoletoDisponivel($codigo, '');
        }

        return response()->json(['message' => 'Todos os boletos foram processados!']);
    }

    public function salvarBoletoDisponivel(string $codigoTitulo, string $codigoIntTitulo)
    {
        try {
            // Chama a API para listar os boletos
            $response = $this->omieApi->obterBoletos($codigoTitulo, $codigoIntTitulo);
            GetTicket::updateOrCreate(
                ['codigo_titulo' => $codigoTitulo], // Se já existir, será atualizado
                [
                    'codigo_int_titulo' => $codigoIntTitulo,
                    'codigo_titulo' => $codigoTitulo,
                    'codigo_status'=> $response['cCodStatus'],
                    'codigo_descricao_status' => $response['cDesStatus'],
                    'data_emissao_boleto' => $response['dDtEmBol'],
                    'numero_boleto' => $response['cNumBoleto'],
                    'codigo_barras' => $response['cCodBarras'],
                    'link_boleto' => $response['cLinkBoleto']
                    ]
            );
            
            return response()->json(['message' => 'Link de Boleto salvo com sucesso!']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao salvar link de boleto: ' . $e->getMessage()], 500);
        }
    }
}
