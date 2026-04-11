<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-settings.layout :heading="__('Perfil')" :subheading="__('Atualize suas informações básicas de nome e e-mail.')">
        <form wire:submit="updateProfileInformation" class="space-y-6">
            <x-field label="Nome">
                <input type="text" wire:model="name" class="input" required autofocus autocomplete="name">
            </x-field>

            <div>
                <x-field label="E-mail">
                    <input type="email" wire:model="email" class="input" required autocomplete="email">
                </x-field>

                @if ($this->hasUnverifiedEmail)
                    <div class="mt-4 p-4 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                        <p class="text-sm text-amber-800 dark:text-amber-400">
                            {{ __('Seu endereço de e-mail ainda não foi verificado.') }}
                            <button type="button" class="font-bold underline cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                            </button>
                        </p>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                <x-button variant="primary" type="submit">{{ __('Salvar Alterações') }}</x-button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <div class="mt-10 pt-10 border-t border-zinc-100 dark:border-zinc-800">
                <livewire:settings.delete-user-form />
            </div>
        @endif
    </x-settings.layout>
</section>
