<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClienteService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pega parâmetros da query string ou usa valores padrão
        $paginaInicial   = (int) $request->query('pagina', 1);
        $porPagina       = (int) $request->query('registros_por_pagina', 20);
        $apenasImportado = (string) $request->query('apenas_importado_api', 'N');

        // Chama o método do serviço para listar e salvar
        return $this->clientService->salvarClientes($paginaInicial, $porPagina, $apenasImportado);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
