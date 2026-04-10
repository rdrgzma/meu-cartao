<?php

use App\Http\Controllers\Api\ValidacaoController;
use App\Livewire\Carencia\CarenciaIndex;
use App\Livewire\Cliente\Carteira;
use App\Livewire\Cliente\Index as ClienteIndex;
use App\Livewire\Especialidade\Index as EspecialidadeIndex;
use App\Livewire\Financeiro\MensalidadeIndex;
use App\Livewire\Financeiro\PagamentoIndex;
use App\Livewire\Notificacao\Configuracao;
use App\Livewire\Notificacao\LogIndex;
use App\Livewire\Parceiro\Index;
use App\Livewire\Plano\Index as PlanoIndex;
use App\Livewire\Relatorio\Financeiro;
use App\Livewire\Sistema\TenantIndex;
use App\Livewire\Sistema\UserIndex;
use App\Livewire\Validacao\Painel;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Clientes
    Route::get('clientes', ClienteIndex::class)->name('clientes.index');

    // Especialidades
    Route::get('especialidades', EspecialidadeIndex::class)->name('especialidades.index');

    // Planos
    Route::get('planos', PlanoIndex::class)->name('planos.index');

    // Financeiro
    Route::get('financeiro', MensalidadeIndex::class)->name('financeiro.index');

    // Carências
    Route::get('carencias', CarenciaIndex::class)->name('carencias.index');

    // Parceiros
    Route::get('parceiros', Index::class)->name('parceiros.index');

    // Validação
    Route::get('validacao', Painel::class)->name('validacao.painel');
    Route::get('meu-painel', \App\Livewire\Parceiro\MeuPainel::class)->name('parceiro.painel');

    // Carteira Virtual (Cliente)
    Route::get('carteira/{id?}', Carteira::class)->name('cliente.carteira');

    // Notificações
    Route::get('notificacoes/config', Configuracao::class)->name('notificacoes.config');
    Route::get('notificacoes/logs', LogIndex::class)->name('notificacoes.logs');

    // Relatórios
    Route::get('relatorios/financeiro', Financeiro::class)->name('relatorios.financeiro');
    Route::get('financeiro/pagamentos', PagamentoIndex::class)->name('financeiro.pagamentos');

    // Sistema
    Route::get('sistema/usuarios', UserIndex::class)->name('sistema.usuarios');
    Route::get('sistema/unidades', TenantIndex::class)->name('sistema.unidades');
});

require __DIR__.'/settings.php';

// API Routes (Simuladas no web.php para facilitar)
Route::prefix('api')->name('api.')->group(function () {
    Route::post('validar', [ValidacaoController::class, 'validar'])->name('validar');
    Route::get('validacao/{token}', [ValidacaoController::class, 'validarToken'])->name('validacao');
});
