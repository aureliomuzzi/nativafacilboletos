<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cria a validação personalizada para CPF ou CNPJ
        Validator::extend('cpf_cnpj', function ($attribute, $value, $parameters, $validator) {
            // Remover todos os caracteres não numéricos
            $value = preg_replace('/\D/', '', $value);

            // Valida CPF (11 dígitos)
            if (strlen($value) == 11) {
                return $this->validarCPF($value);
            }

            // Valida CNPJ (14 dígitos)
            if (strlen($value) == 14) {
                return $this->validarCNPJ($value);
            }

            return false;
        });
    }

    
}
