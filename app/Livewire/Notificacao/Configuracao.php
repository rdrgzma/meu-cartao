<?php

namespace App\Livewire\Notificacao;

use App\Models\Notificacao;
use Livewire\Component;

class Configuracao extends Component
{
    public array $templates = [];
    public bool $showingModal = false;
    public string $newTipo = '';
    public string $newAssunto = '';
    public string $newTemplate = '';
    public string $search = '';

    public function mount(): void
    {
        if (!in_array(auth()->user()->funcao, ['sistema', 'admin'])) {
            abort(403, 'Acesso restrito.');
        }

        $this->ensureDefaultTemplates();
        $this->loadTemplates();
    }

    protected function ensureDefaultTemplates(): void
    {
        if (! app()->bound('tenant')) {
            return;
        }

        $tenantId = app('tenant')->id;

        $defaults = [
            [
                'tipo' => 'lembrete_pagamento',
                'assunto' => 'Lembrete de Mensalidade',
                'template' => 'Olá {{nome}}, sua mensalidade de {{valor}} vence em {{vencimento}}. Acesse sua carteira: {{link_carteira}}',
            ],
            [
                'tipo' => 'aviso_atraso',
                'assunto' => 'Mensalidade em Atraso',
                'template' => 'Olá {{nome}}, notamos um atraso de {{dias_atraso}} dias no seu pagamento. Regularize agora para manter seus benefícios.',
            ],
            [
                'tipo' => 'confirmacao_pagamento',
                'assunto' => 'Pagamento Confirmado',
                'template' => 'Olá {{nome}}, seu pagamento foi processado com sucesso. Obrigado por manter seu Cartão Mais Saúde ativo!',
            ],
        ];

        foreach ($defaults as $default) {
            Notificacao::firstOrCreate(
                ['tipo' => $default['tipo'], 'tenant_id' => $tenantId],
                array_merge($default, ['tenant_id' => $tenantId])
            );
        }
    }

    public function loadTemplates(): void
    {
        $this->templates = Notificacao::query()
            ->with('tenant')
            ->when($this->search, function ($q) {
                $q->where('assunto', 'like', "%{$this->search}%")
                  ->orWhereHas('tenant', fn($t) => $t->where('nome', 'like', "%{$this->search}%"));
            })
            ->get()
            ->toArray();
    }

    public function updatedSearch(): void
    {
        $this->loadTemplates();
    }

    public function openCreateModal(): void
    {
        $this->reset(['newTipo', 'newAssunto', 'newTemplate']);
        $this->showingModal = true;
    }

    public function createNotification(): void
    {
        $this->validate([
            'newTipo' => 'required|string|max:50',
            'newAssunto' => 'required|string|max:255',
            'newTemplate' => 'required|string',
        ]);

        Notificacao::create([
            'tipo' => $this->newTipo,
            'assunto' => $this->newAssunto,
            'template' => $this->newTemplate,
            'ativo' => true,
        ]);

        $this->showingModal = false;
        $this->loadTemplates();

        $this->dispatch('notify',
            title: 'Criado',
            description: 'Nova notificação personalizada criada.',
            type: 'success'
        );
    }

    public function delete(int $id): void
    {
        Notificacao::destroy($id);
        $this->loadTemplates();
        
        $this->dispatch('notify',
            title: 'Excluído',
            description: 'Notificação removida.',
            type: 'info'
        );
    }

    public function save(int $index): void
    {
        $data = $this->templates[$index];

        $template = Notificacao::find($data['id']);
        $template->update([
            'template' => $data['template'],
            'ativo' => $data['ativo'],
        ]);

        $this->dispatch('notify',
            title: 'Salvo',
            description: "Template {$template->assunto} atualizado.",
            type: 'success'
        );
    }

    public function render()
    {
        return view('livewire.notificacao.configuracao');
    }
}
