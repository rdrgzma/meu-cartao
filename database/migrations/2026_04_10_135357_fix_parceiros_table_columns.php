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
        Schema::table('parceiros', function (Blueprint $table) {
            if (! Schema::hasColumn('parceiros', 'tenant_id')) {
                $table->foreignId('tenant_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
            }
            if (! Schema::hasColumn('parceiros', 'nome_fantasia')) {
                $table->string('nome_fantasia')->after('tenant_id')->nullable();
            }
            if (! Schema::hasColumn('parceiros', 'razao_social')) {
                $table->string('razao_social')->after('nome_fantasia')->nullable();
            }
            if (! Schema::hasColumn('parceiros', 'documento')) {
                $table->string('documento')->after('razao_social')->nullable();
            }
            if (! Schema::hasColumn('parceiros', 'telefone')) {
                $table->string('telefone')->after('documento')->nullable();
            }
            if (! Schema::hasColumn('parceiros', 'endereco')) {
                $table->string('endereco')->after('telefone')->nullable();
            }
            if (! Schema::hasColumn('parceiros', 'cidade')) {
                $table->string('cidade')->after('endereco')->nullable();
            }
            if (! Schema::hasColumn('parceiros', 'estado')) {
                $table->string('estado', 2)->after('cidade')->nullable();
            }
            if (! Schema::hasColumn('parceiros', 'status')) {
                $table->enum('status', ['ativo', 'inativo'])->after('estado')->default('ativo');
            }
            if (! Schema::hasColumn('parceiros', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parceiros', function (Blueprint $table) {
            //
        });
    }
};
