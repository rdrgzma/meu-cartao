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
        if (! Schema::hasTable('parceiro_especialidades')) {
            Schema::create('parceiro_especialidades', function (Blueprint $table) {
                $table->id();

                $table->foreignId('parceiro_id')->constrained()->cascadeOnDelete();
                $table->foreignId('especialidade_id')->constrained()->cascadeOnDelete();
                $table->decimal('valor_desconto', 10, 2)->default(0);
                $table->unique(['parceiro_id', 'especialidade_id']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parceiro_especialidades');
    }
};
