<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use App\Services\OmieApiService;
use App\Helpers\FuncoesHelper;
use Exception;

class ClientOmieService
{
    protected $omieApi;

    public function __construct(OmieApiService $omieApi)
    {
        $this->omieApi = $omieApi;
    }

    public function salvarClientes(string $apenasImportadoApi = 'N')
    {
        try {
            // Chama a API para listar os clientes
            $response = $this->omieApi->listarClientes($apenasImportadoApi);
            
            // Itera sobre cada cliente e salva no banco
            foreach ($response['clientes_cadastro'] as $clienteData) {
                Client::updateOrCreate(
                    ['cnpj_cpf' => $clienteData['cnpj_cpf']], // Se já existir, será atualizado
                    [
                        'codigo_cliente_omie' => $clienteData['codigo_cliente_omie'],
                        'razao_social' => $clienteData['razao_social'],
                        'nome_fantasia'=> $clienteData['nome_fantasia'],
                        'cnpj_cpf'=> $clienteData['cnpj_cpf'],
                        'estado'=> $clienteData['estado'],
                        'pessoa_fisica'=> $clienteData['pessoa_fisica'],
                        'tags'=> json_encode($clienteData['tags']),
                        'inativo'=> $clienteData['inativo'],
                    ]
                );

                $this->criarUsuario($clienteData['cnpj_cpf'], $clienteData['razao_social']);
            }

            return response()->json(['message' => 'Clientes salvos com sucesso!']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao salvar clientes: ' . $e->getMessage()], 500);
        }
    }

    public function criarUsuario(string $cnpjCpf, string $razaoSocial)
    {
        $senhaCpf = FuncoesHelper::removerCaracter($cnpjCpf);
        $emailCpf = FuncoesHelper::removerCaracter($cnpjCpf);

        User::updateOrCreate(
            ['cnpj_cpf' => $cnpjCpf], // Se já existir, será atualizado
            [
                'name' => $razaoSocial,
                'cnpj_cpf' => $cnpjCpf,
                'email' => $emailCpf . '@abc.com',
                'password' => bcrypt($senhaCpf),
            ]
        );   
    }
}
