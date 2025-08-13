<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_cliente_omie', 12);
            $table->string('razao_social',250);
            $table->string('nome_fantasia', 250)->nullable();
            $table->string('cnpj_cpf', 20);
            $table->string('estado',2);
            $table->string('pessoa_fisica', 1);
            $table->string('tag', 15);  // Cliente | Operadora | Corretora
            $table->string('inativo', 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
