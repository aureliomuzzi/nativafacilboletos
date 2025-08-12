<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObterBoletoController;

Route::get('/omie/contas-receber', [ObterBoletoController::class, 'index']);
