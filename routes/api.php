<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\ObterBoletoController;
use App\Http\Controllers\ClientController;

Route::get('/omie/contas-receber', [ObterBoletoController::class, 'index']);
Route::get('/omie/clientes', [ClientController::class, 'index']);
