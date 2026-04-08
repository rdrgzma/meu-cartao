<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('cns', 15)->nullable()->after('cpf');

            $table->unique(['tenant_id','cns']);
            $table->index('cns');
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropUnique(['tenant_id','cns']);
            $table->dropColumn('cns');
        });
    }
};