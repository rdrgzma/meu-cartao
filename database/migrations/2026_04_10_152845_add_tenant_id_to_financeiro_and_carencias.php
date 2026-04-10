<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mensalidades', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('pagamentos', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
        });

        Schema::table('carencias', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
        });
        
        // Populando dados existentes (opcional, mas bom para integridade)
        // Como o SQLite tem limitações, faremos via código se necessário ou deixaremos nulo por enquanto
    }

    public function down(): void
    {
        Schema::table('mensalidades', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
        });

        Schema::table('carencias', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
        });
    }
};
