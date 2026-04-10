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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'tenant_id')) {
                $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
            }
            if (! Schema::hasColumn('users', 'parceiro_id')) {
                $table->foreignId('parceiro_id')->nullable()->constrained()->cascadeOnDelete();
            }
            if (! Schema::hasColumn('users', 'cliente_id')) {
                $table->foreignId('cliente_id')->nullable()->constrained()->cascadeOnDelete();
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            }
            if (! Schema::hasColumn('users', 'tipo')) {
                $table->enum('tipo', ['admin', 'usuario'])->default('usuario');
            }
            if (! Schema::hasColumn('users', 'funcao')) {
                $table->enum('funcao', ['sistema', 'admin', 'parceiro', 'cliente'])->default('cliente');
            }
            if (! Schema::hasColumn('users', 'telefone')) {
                $table->string('telefone')->nullable();
            }
            if (! Schema::hasColumn('users', 'documento')) {
                $table->string('documento')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tenant_id', 'parceiro_id', 'cliente_id', 'status', 'tipo', 'funcao', 'telefone', 'documento']);
        });
    }
};
