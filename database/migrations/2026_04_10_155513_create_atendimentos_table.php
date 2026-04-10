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
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('cliente_id')->constrained();
            $table->foreignId('parceiro_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained(); // quem realizou a validação
            $table->foreignId('especialidade_id')->constrained();
            $table->string('status'); // liberado, negado, em_carencia, etc
            $table->timestamp('data_atendimento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};
