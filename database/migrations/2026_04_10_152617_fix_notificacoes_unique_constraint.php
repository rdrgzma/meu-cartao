<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            // Remove a unicidade global do tipo
            $table->dropUnique(['tipo']);
            
            // Adiciona a unicidade composta por tenant e tipo
            $table->unique(['tenant_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            $table->dropUnique(['tenant_id', 'tipo']);
            $table->unique(['tipo']);
        });
    }
};
