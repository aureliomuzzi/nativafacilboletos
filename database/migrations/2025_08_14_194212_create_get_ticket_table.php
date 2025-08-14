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
        Schema::create('get_tickets', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_titulo'); // nCodTitulo
            $table->string('codigo_int_titulo')->nullable(); // cCodIntTitulo
            $table->string('codigo_status'); // cCodStatus
            $table->string('data_emissao_boleto', 10)->nullable(); // dDtEmBol
            $table->string('numero_boleto')->nullable(); // cNumBoleto
            $table->string('codigo_barras')->nullable(); // cCodBarras
            $table->string('link_boleto')->nullable(); // cLinkBoleto

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('get_ticket');
    }
};
