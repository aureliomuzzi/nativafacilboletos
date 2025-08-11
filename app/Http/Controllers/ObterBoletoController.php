<?php

use App\Services\OmieApi;

class ObterBoletoController
{
    public function index(OmieApi $api)
    {
        $data = $api->listarContasReceber(
            [
                'pagina' => 1, 
                'registros_por_pagina' => 20, 
                'apenas_importado_api' => 'N'
            ]
        );
        return response()->json($data);
    }
}
