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
            $table->boolean('can_access_dashboard')->default(false);
            $table->boolean('can_access_financeiro')->default(false);
            $table->boolean('can_access_relatorios')->default(false);
            $table->boolean('can_access_planos')->default(false);
            $table->boolean('can_access_especialidades')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'can_access_dashboard',
                'can_access_financeiro',
                'can_access_relatorios',
                'can_access_planos',
                'can_access_especialidades'
            ]);
        });
    }
};
