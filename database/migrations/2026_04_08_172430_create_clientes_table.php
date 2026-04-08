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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();

            $table->string('nome');
            $table->string('cpf');
            $table->string('telefone');
            $table->string('email')->nullable();

            $table->date('data_adesao');

            $table->enum('status', ['ativo','inadimplente','cancelado'])
                  ->default('ativo');

            $table->foreignId('plano_id')->nullable()
                  ->constrained()->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id','cpf']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
