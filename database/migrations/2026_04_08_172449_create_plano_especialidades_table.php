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
        Schema::create('plano_especialidades', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('plano_id')->constrained()->cascadeOnDelete();
            $table->foreignId('especialidade_id')->constrained()->cascadeOnDelete();
            $table->enum('tipo_cobertura', ['total','desconto'])->default('desconto');
            $table->unique(['plano_id','especialidade_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_especialidades');
    }
};
