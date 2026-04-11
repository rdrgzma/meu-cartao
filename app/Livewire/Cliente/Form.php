<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use App\Services\ClienteService;
use App\Services\PlanoService;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    #[On('reset-form')]
    public function resetFormListener(): void
    {
        $this->resetForm();
    }

    public ?Cliente $cliente = null;

    public ?string $nome = '';

    public ?string $cpf = '';

    public ?string $cns = '';

    public ?string $email = '';

    public ?string $telefone = '';

    public ?string $data_adesao = '';

    public ?string $status = 'ativo';

    public ?int $plano_id = null;

    public function mount(): void
    {
        $this->data_adesao = now()->format('Y-m-d');
    }

    #[On('edit-cliente')]
    public function edit(int $id): void
    {
        $this->cliente = Cliente::findOrFail($id);
        $this->nome = $this->cliente->nome ?? '';
        $this->cpf = $this->cliente->cpf ?? '';
        $this->cns = $this->cliente->cns ?? '';
        $this->email = $this->cliente->email ?? '';
        $this->telefone = $this->cliente->telefone ?? '';
        $this->data_adesao = $this->cliente->data_adesao instanceof \DateTime
            ? $this->cliente->data_adesao->format('Y-m-d')
            : ($this->cliente->data_adesao ?? '');
        $this->status = $this->cliente->status ?? 'ativo';
        $this->plano_id = $this->cliente->plano_id;

        $this->resetErrorBag();
    }

    public function resetForm(): void
    {
        $this->reset(['cliente', 'nome', 'cpf', 'cns', 'email', 'telefone', 'plano_id']);
        $this->data_adesao = now()->format('Y-m-d');
        $this->status = 'ativo';
        $this->resetErrorBag();
    }

    public function save(ClienteService $service, bool $stay = false): void
    {
        $rules = [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'unique:clientes,cpf,'.($this->cliente?->id ?? 'NULL')],
            'cns' => ['nullable', 'string', 'unique:clientes,cns,'.($this->cliente?->id ?? '')],
            'email' => ['required', 'email', 'unique:clientes,email,'.($this->cliente?->id ?? 'NULL')],
            'telefone' => ['required', 'string'],
            'data_adesao' => ['required', 'date'],
            'status' => ['required', 'in:ativo,inadimplente,cancelado'],
            'plano_id' => ['required', 'exists:planos,id'],
        ];

        $data = $this->validate($rules);

        try {
            if ($this->cliente) {
                $service->update($this->cliente, $data);
                $msg = 'Cliente atualizado com sucesso.';
            } else {
                $service->criar($data);
                $msg = 'Cliente cadastrado com sucesso.';
            }

            $this->dispatch('clienteUpdated');

            if (! $stay) {
                $this->dispatch('close-modal');
            }

            $this->dispatch('notify',
                title: 'Sucesso',
                description: $msg,
                type: 'success'
            );

            $this->resetForm();
        } catch (\Exception $e) {
            $this->addError('cns', $e->getMessage());
        }
    }

    public function render(PlanoService $planoService)
    {
        return view('livewire.cliente.form', [
            'planos' => $planoService->getActive(),
        ]);
    }
}
