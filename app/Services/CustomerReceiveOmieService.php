<?php

namespace App\Services;

use App\Models\CustomerReceive;
use App\Services\OmieApiService;
use Exception;

class CustomerReceiveOmieService
{
    protected $omieApi;

    public function __construct(OmieApiService $omieApi)
    {
        $this->omieApi = $omieApi;
    }

    public function salvarContasReceber(string $apenasImportadoApi = 'N')
    {
        try {
            // Chama a API para listar os clientes
            $response = $this->omieApi->listarContasReceber($apenasImportadoApi);
            // Itera sobre cada cliente e salva no banco
            foreach ($response['conta_receber_cadastro'] as $contaReceberData) {
                CustomerReceive::updateOrCreate(
                    ['codigo_cliente_fornecedor' => $contaReceberData['codigo_cliente_fornecedor']], // Se já existir, será atualizado
                    [
                        'codigo_lancamento_omie'    => $contaReceberData['codigo_lancamento_omie'],
                        'codigo_cliente_fornecedor'=> $contaReceberData['codigo_cliente_fornecedor'],
                        'codigo_lancamento_integracao' => $contaReceberData['codigo_lancamento_integracao'],
                        'codigo_gerado' => $contaReceberData['boleto']['cGerado'],
                    ]
                );
            }

            return response()->json(['message' => 'Lancamentos salvos com sucesso!']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao salvar lancamentos: ' . $e->getMessage()], 500);
        }
    }
}
