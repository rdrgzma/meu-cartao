<section class="space-y-6">
    <div class="relative">
        <h4 class="text-lg font-bold text-red-600 dark:text-red-400">{{ __('Excluir Conta') }}</h4>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Exclua sua conta e todos os dados associados permanentemente.') }}</p>
    </div>

    <x-button variant="danger" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Excluir Minha Conta') }}
    </x-button>

    <x-modal name="confirm-user-deletion" title="Tem certeza que deseja excluir sua conta?">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                <p class="text-sm text-red-800 dark:text-red-400">
                    {{ __('Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente apagados. Por favor, digite sua senha para confirmar que deseja excluir permanentemente sua conta.') }}
                </p>
            </div>

            <x-field label="Senha">
                <input type="password" wire:model="password" class="input" placeholder="Digite sua senha para confirmar">
            </x-field>

            <div class="flex justify-end gap-3 mt-8">
                <x-button variant="zinc" @click="$dispatch('close-modal', 'confirm-user-deletion')">
                    {{ __('Cancelar') }}
                </x-button>

                <x-button variant="danger" type="submit">
                    {{ __('Sim, Excluir Conta') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
