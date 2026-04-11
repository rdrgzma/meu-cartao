<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Security settings') }}</flux:heading>

    <x-settings.layout :heading="__('Segurança')" :subheading="__('Garanta que sua conta esteja usando uma senha forte e autenticação de dois fatores.')">
        <div class="space-y-12">
            {{-- Alterar Senha --}}
            <section>
                <header class="mb-4">
                    <h4 class="text-md font-bold text-zinc-900 dark:text-white">{{ __('Alterar Senha') }}</h4>
                </header>
                
                <form method="POST" wire:submit="updatePassword" class="space-y-4">
                    <x-field label="Senha Atual">
                        <input type="password" wire:model="current_password" class="input" required autocomplete="current-password">
                    </x-field>

                    <x-field label="Nova Senha">
                        <input type="password" wire:model="password" class="input" required autocomplete="new-password">
                    </x-field>

                    <x-field label="Confirmar Nova Senha">
                        <input type="password" wire:model="password_confirmation" class="input" required autocomplete="new-password">
                    </x-field>

                    <div class="flex items-center gap-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <x-button variant="primary" type="submit">{{ __('Atualizar Senha') }}</x-button>
                    </div>
                </form>
            </section>

            {{-- 2FA --}}
            @if ($canManageTwoFactor)
                <section class="pt-10 border-t border-zinc-100 dark:border-zinc-800">
                    <header class="mb-4">
                        <h4 class="text-md font-bold text-zinc-900 dark:text-white">{{ __('Autenticação em Dois Fatores (2FA)') }}</h4>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Adicione uma camada extra de segurança à sua conta usando um aplicativo autenticador.') }}</p>
                    </header>

                    <div class="mt-6" wire:cloak>
                        @if ($twoFactorEnabled)
                            <div class="space-y-6">
                                <div class="p-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3">
                                    <x-icons.check-circle class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                    <p class="text-sm text-emerald-800 dark:text-emerald-400 font-medium">
                                        {{ __('A autenticação em dois fatores está ATIVADA.') }}
                                    </p>
                                </div>

                                <div class="flex gap-3">
                                    <x-button variant="danger" wire:click="disable">
                                        {{ __('Desativar 2FA') }}
                                    </x-button>
                                </div>

                                <livewire:settings.two-factor.recovery-codes :$requiresConfirmation/>
                            </div>
                        @else
                            <div class="space-y-4">
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ __('Quando ativado, você precisará fornecer um código seguro gerado pelo seu celular durante o login.') }}
                                </p>

                                <x-button variant="primary" wire:click="enable">
                                    {{ __('Ativar Autenticação 2FA') }}
                                </x-button>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- Modal de Configuração 2FA --}}
                <x-modal name="two-factor-setup-modal" :title="$this->modalConfig['title']" wire:model="showModal">
                    <div class="space-y-6">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $this->modalConfig['description'] }}
                        </p>

                        @if ($showVerificationStep)
                            <div class="space-y-4">
                                <x-field label="Código de Confirmação">
                                    <input type="text" wire:model="code" maxlength="6" class="input text-center text-xl tracking-[0.5em] font-mono" placeholder="000000" autofocus>
                                </x-field>

                                <div class="flex gap-3">
                                    <x-button variant="zinc" class="flex-1" wire:click="resetVerification">
                                        {{ __('Voltar') }}
                                    </x-button>

                                    <x-button variant="primary" class="flex-1" wire:click="confirmTwoFactor" :disabled="strlen($code) < 6">
                                        {{ __('Confirmar') }}
                                    </x-button>
                                </div>
                            </div>
                        @else
                            @error('setupData')
                                <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="flex flex-col items-center gap-6">
                                <div class="p-4 bg-white rounded-xl shadow-inner border border-zinc-200 dark:border-zinc-800">
                                    @empty($qrCodeSvg)
                                        <div class="w-48 h-48 flex items-center justify-center">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-zinc-900 dark:border-white"></div>
                                        </div>
                                    @else
                                        <div class="qr-code">
                                            {!! $qrCodeSvg !!}
                                        </div>
                                    @endempty
                                </div>

                                <div class="w-full">
                                    <p class="text-[10px] font-bold uppercase text-zinc-400 mb-2">{{ __('Ou insira o código manualmente:') }}</p>
                                    <div class="flex items-center gap-2 p-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                        <code class="flex-1 text-xs font-mono truncate px-2">{{ $manualSetupKey }}</code>
                                        <x-button variant="zinc" size="sm" x-data="{ copied: false }" @click="navigator.clipboard.writeText('{{ $manualSetupKey }}'); copied = true; setTimeout(() => copied = false, 2000)">
                                            <span x-show="!copied">{{ __('Copiar') }}</span>
                                            <span x-show="copied" class="text-emerald-500">{{ __('Copiado!') }}</span>
                                        </x-button>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800">
                                <x-button variant="primary" class="w-full" wire:click="showVerificationIfNecessary" :disabled="$errors->has('setupData')">
                                    {{ $this->modalConfig['buttonText'] }}
                                </x-button>
                            </div>
                        @endif
                    </div>
                </x-modal>
            @endif
        </div>
    </x-settings.layout>
</section>
