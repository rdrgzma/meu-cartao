<x-modal name="tenant-modal" :title="$tenant ? __('Editar Unidade') : __('Nova Unidade')">
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Nome da Unidade">
                <input type="text" wire:model.live="nome" class="input" placeholder="Ex: Cartão Mais Saúde - Centro">
            </x-field>
            <x-field label="Slug / Identificador">
                <input type="text" wire:model="slug" class="input font-mono text-xs" placeholder="ex-centro-saude">
            </x-field>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-field label="Documento (CNPJ)">
                <input type="text" wire:model="documento" class="input font-mono" placeholder="00.000.000/0001-00">
            </x-field>
            <x-field label="Telefone">
                <input type="text" wire:model="telefone" class="input" placeholder="(00) 0000-0000">
            </x-field>
        </div>

        <x-field label="Endereço">
            <input type="text" wire:model="endereco" class="input" placeholder="Rua, Número, Bairro">
        </x-field>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-2">
                <x-field label="Cidade">
                    <input type="text" wire:model="cidade" class="input">
                </x-field>
            </div>
            <x-field label="Estado / UF">
                <input type="text" wire:model="estado" class="input text-center uppercase" maxlength="2">
            </x-field>
        </div>

        <x-field label="Status da Unidade">
            <select wire:model="status" class="select">
                <option value="ativo">{{ __('Ativa (Acesso Liberado)') }}</option>
                <option value="inativo">{{ __('Inativa (Acesso Bloqueado)') }}</option>
            </select>
            <p class="mt-1 text-xs text-zinc-500">{{ __('Unidades inativas bloqueiam o acesso de todos os seus usuários.') }}</p>
        </x-field>

        <div class="flex justify-between items-center gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <div>
                @if($tenant)
                    <x-button type="button" variant="danger" size="sm"
                        wire:confirm="Tem certeza que deseja excluir esta unidade? Isso bloqueará o acesso de todos os parceiros e clientes vinculados. Os dados serão preservados por segurança (exclusão lógica)."
                        wire:click="delete">
                        {{ __('Excluir') }}
                    </x-button>
                @endif
            </div>
            <div class="flex gap-3">
                <x-button type="button" variant="ghost" @click="$dispatch('close-modal')">
                    {{ __('Cancelar') }}
                </x-button>
                <x-button type="submit" variant="primary">
                    {{ $tenant ? __('Salvar Alterações') : __('Cadastrar Unidade') }}
                </x-button>
            </div>
        </div>
    </form>
</x-modal>
