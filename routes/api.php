<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObterBoletoController;
use App\Http\Controllers\ClientController;

Route::get('/omie/contas-receber', [ObterBoletoController::class, 'index']);
Route::get('/omie/clientes', [ClientController::class, 'index']);
