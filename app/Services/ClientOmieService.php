<?php

namespace App\Services;

use App\Models\Client;
use App\Services\OmieApiService;
use Exception;

class ClienteService
{
    protected $omieApi;

    public function __construct(OmieApiService $omieApi)
    {
        $this->omieApi = $omieApi;
    }

    public function salvarClientes(int $pagina = 1, int $porPagina = 20, string $apenasImportadoApi = 'N', array $filtrosExtras = [])
    {
        try {
            // Chama a API para listar os clientes
            $response = $this->omieApi->listarClientes($pagina, $porPagina, $apenasImportadoApi, $filtrosExtras);
            
            // Itera sobre cada cliente e salva no banco
            foreach ($response['clientes_cadastro'] as $clienteData) {
                Client::updateOrCreate(
                    ['id' => $clienteData['id']], // Se já existir, será atualizado
                    [
                        'codigo_cliente_omie'    => $clienteData['codigo_cliente_omie'],
                        'razao_social'   => $clienteData['razao_social'],
                        'nome_fantasia'=> $clienteData['nome_fantasia'],
                        'cnpj_cpf'=> $clienteData['cnpj_cpf'],
                        'estado'=> $clienteData['estado'],
                        'pessoa_fisica'=> $clienteData['pessoa_fisica'],
                        'tag'=> $clienteData['tag'],
                        'inativo'=> $clienteData['inativo'],
                    ]
                );
            }

            return response()->json(['message' => 'Clientes salvos com sucesso!']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao salvar clientes: ' . $e->getMessage()], 500);
        }
    }
}
