<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\CustomerReceiveController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GetTicketController;

Route::get('/omie/clientes', [ClientController::class, 'index']);
Route::get('/omie/contas-receber', [CustomerReceiveController::class, 'index']);
Route::get('/omie/contas-receber/boletos', [GetTicketController::class, 'index']);
