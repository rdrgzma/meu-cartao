<div class="page-section">
    <div class="page-header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Logs do Sistema') }}</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Auditoria completa de ações realizadas na plataforma.') }}</p>
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="filter-bar">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-zinc-400">
                        <x-icons.home class="w-5 h-5" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Buscar por descrição ou ação..." class="input pl-10">
                </div>

                <div class="w-full md:w-48">
                    <select wire:model.live="modulo" class="select">
                        <option value="">{{ __('Todos os Módulos') }}</option>
                        <option value="Financeiro">{{ __('Financeiro') }}</option>
                        <option value="Clientes">{{ __('Clientes') }}</option>
                        <option value="Sistema">{{ __('Sistema') }}</option>
                        <option value="Parceiros">{{ __('Parceiros') }}</option>
                        <option value="Planos">{{ __('Planos') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <x-table :paginate="$logs">
            <x-slot name="columns">
                <th class="px-6 py-4 font-semibold w-40">{{ __('Data') }}</th>
                <th class="px-6 py-4 font-semibold w-32">{{ __('Módulo') }}</th>
                <th class="px-6 py-4 font-semibold w-48">{{ __('Usuário') }}</th>
                <th class="px-6 py-4 font-semibold w-48">{{ __('Organização') }}</th>
                <th class="px-6 py-4 font-semibold">{{ __('Ação / Descrição') }}</th>
                <th class="px-6 py-4 font-semibold w-32 text-center">{{ __('Detalhes') }}</th>
            </x-slot>

            @foreach ($logs as $log)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors text-sm">
                    <td class="px-6 py-4 whitespace-nowrap text-zinc-500 font-mono text-[11px]">
                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-800 text-[10px] font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">
                            {{ $log->modulo }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span
                                class="font-semibold text-zinc-900 dark:text-white">{{ $log->user->name ?? 'Sistema' }}</span>
                            <span class="text-[10px] text-zinc-500">{{ $log->ip_address }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $log->tenant->nome ?? __('Suporte Global') }}</span>
                            @if($log->tenant)
                                <span class="text-[10px] text-zinc-500 font-mono">ID: #{{ $log->tenant_id }} &bull; {{ $log->tenant->documento }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $log->acao }}</span>
                            <span class="text-xs text-zinc-500 line-clamp-1">{{ $log->descricao }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($log->dados)
                            <x-button variant="ghost" size="sm" icon="document-text" wire:click="showDetails({{ $log->id }})"
                                title="Ver dados detalhados">
                                <span class="sr-only">Detalhes</span>
                            </x-button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>

    {{-- Modal de Detalhes --}}
    <x-modal name="log-details" title="Detalhes do Evento">
        @if($selectedLog)
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-zinc-500">{{ __('Módulo / Ação') }}</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $selectedLog->modulo }} /
                            {{ $selectedLog->acao }}</p>
                    </div>
                    <div>
                        <p class="text-zinc-500">{{ __('Realizado em') }}</p>
                        <p class="font-bold text-zinc-900 dark:text-white">
                            {{ $selectedLog->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-zinc-500">{{ __('Usuário') }}</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $selectedLog->user->name ?? 'Sistema' }}</p>
                    </div>
                    <div>
                        <p class="text-zinc-500">{{ __('IP') }}</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $selectedLog->ip_address }}</p>
                    </div>
                    <div>
                        <p class="text-zinc-500">{{ __('Organização / Unidade') }}</p>
                        <p class="font-bold text-zinc-900 dark:text-white">
                            {{ $selectedLog->tenant->nome ?? __('Suporte Global') }}
                            @if($selectedLog->tenant)
                                <span class="block text-xs font-normal text-zinc-500 mt-1">
                                    ID: #{{ $selectedLog->tenant_id }} | Documento: {{ $selectedLog->tenant->documento ?? 'N/A' }}
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <p class="text-xs font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-3">
                        {{ __('Dados da Operação') }}</p>

                    <div class="overflow-hidden border border-zinc-200 dark:border-zinc-800 rounded-xl bg-zinc-50/30 dark:bg-zinc-900/50">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                @if($selectedLog->tenant)
                                    <tr class="group hover:bg-white dark:hover:bg-zinc-800/40 transition-colors">
                                        <td class="px-4 py-3.5 text-xs font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider w-1/3 bg-zinc-50/50 dark:bg-zinc-800/30">
                                            {{ __('Unidade / Org') }}
                                        </td>
                                        <td class="px-4 py-3.5 text-sm font-semibold text-zinc-900 dark:text-white">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500">
                                                    <x-icons.building-library class="w-4 h-4" />
                                                </div>
                                                <div class="flex flex-col">
                                                    <span>{{ $selectedLog->tenant->nome }}</span>
                                                    <span class="text-[10px] text-zinc-400 font-normal">ID: #{{ $selectedLog->tenant_id }} &bull; {{ $selectedLog->tenant->documento ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                                @foreach($selectedLog->dados as $key => $value)
                                    @if($key === 'tenant_id') @continue @endif
                                    <tr class="group hover:bg-white dark:hover:bg-zinc-800/40 transition-colors">
                                        <td class="px-4 py-3.5 text-xs font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider bg-zinc-50/50 dark:bg-zinc-800/30">
                                            {{ str_replace(['_', 'id'], [' ', 'ID'], $key) }}
                                        </td>
                                        <td class="px-4 py-3.5 text-sm font-medium">
                                            @php $label = $selectedLog->resolveLabel($key, $value); @endphp

                                            @if($key === 'status')
                                                <x-badge :color="$value === 'ativo' ? 'green' : 'red'">
                                                    {{ ucfirst($value) }}
                                                </x-badge>
                                            @elseif(is_bool($value) || in_array($value, [true, false, 'true', 'false'], true))
                                                @php $boolVal = filter_var($value, FILTER_VALIDATE_BOOLEAN); @endphp
                                                <div class="flex items-center gap-1.5 {{ $boolVal ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                    @if($boolVal)
                                                        <x-icons.check-circle class="w-4 h-4" />
                                                        <span class="text-xs font-bold">{{ __('Sim') }}</span>
                                                    @else
                                                        <x-icons.x-circle class="w-4 h-4" />
                                                        <span class="text-xs font-bold">{{ __('Não') }}</span>
                                                    @endif
                                                </div>
                                            @elseif(is_array($label))
                                                <div class="flex flex-wrap gap-1.5">
                                                    @foreach($label as $idx => $l)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 text-[10px] font-bold">
                                                            {{ $l }}
                                                            <span class="ml-1 text-zinc-400 font-normal">#{{ is_array($value) ? $value[$idx] : $value }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @elseif($label)
                                                <div class="flex items-center gap-2">
                                                    <span class="text-zinc-900 dark:text-white font-bold">{{ $label }}</span>
                                                    <span class="px-1.5 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-[10px] text-zinc-400 border border-zinc-200 dark:border-zinc-700 font-mono">#{{ $value }}</span>
                                                </div>
                                            @elseif(str_contains($key, 'valor') || str_contains($key, 'preco'))
                                                <span class="font-mono text-emerald-600 dark:text-emerald-400 font-bold">
                                                    R$ {{ number_format((float) $value, 2, ',', '.') }}
                                                </span>
                                            @elseif(is_string($value) && (strlen($value) > 50))
                                                <div class="text-xs text-zinc-600 dark:text-zinc-400 bg-zinc-100/50 dark:bg-zinc-800/50 p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 max-h-24 overflow-y-auto font-mono">
                                                    {{ $value }}
                                                </div>
                                            @else
                                                <span class="text-zinc-700 dark:text-zinc-300">{{ $value }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div x-data="{ open: false }" class="mt-4">
                        <button @click="open = !open"
                            class="inline-flex items-center gap-1.5 text-[10px] font-bold text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors uppercase tracking-widest">
                            <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('Dados Técnicos (JSON)') }}
                        </button>
                        <div x-show="open" x-collapse
                            class="mt-2 bg-zinc-950 p-4 rounded-xl shadow-inner border border-zinc-800">
                            <pre
                                class="text-[10px] font-mono text-emerald-400 overflow-x-auto leading-relaxed">{{ json_encode($selectedLog->dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                </div>

                <div
                    class="pt-4 text-[10px] text-zinc-400 font-mono italic truncate border-t border-zinc-100 dark:border-zinc-800/50 mt-4 opacity-75">
                    {{ $selectedLog->user_agent }}
                </div>
            </div>
        @endif
    </x-modal>
</div>