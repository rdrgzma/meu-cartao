<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZapFlow Health OS - Inteligência para Operadoras e Prestadores</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,600,800|plus-jakarta-sans:400,500,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Outfit', sans-serif; }
        .glass-health {
            background: rgba(16, 185, 129, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.1);
        }
        .text-glow-emerald {
            text-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-300 selection:bg-emerald-500/30 overflow-x-hidden">
    {{-- Dynamic Bio-Glow --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-emerald-600/10 blur-[150px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[40%] h-[40%] bg-teal-600/10 blur-[150px] rounded-full"></div>
    </div>

    {{-- Navigation --}}
    <header x-data="{ scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 20" 
        :class="scrolled ? 'bg-zinc-950/90 backdrop-blur-xl border-zinc-900 py-4' : 'bg-transparent border-transparent py-6'"
        class="fixed top-0 inset-x-0 z-50 transition-all duration-500 border-b">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <div class="flex items-center gap-2.5 group">
                <div class="p-2 bg-emerald-500 rounded-lg group-hover:rotate-12 transition-transform duration-300">
                    <x-icons.shield-check class="h-6 w-6 text-zinc-950" />
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tight text-white leading-none">ZAPFLOW</span>
                    <span class="text-[10px] font-bold tracking-[0.2em] text-emerald-500 uppercase">Health OS</span>
                </div>
            </div>

            <nav class="hidden lg:flex items-center gap-10 text-[13px] font-bold uppercase tracking-widest text-zinc-500">
                <a href="#operadoras" class="hover:text-emerald-500 transition-colors">Para Operadoras</a>
                <a href="#prestadores" class="hover:text-emerald-500 transition-colors">Para Prestadores</a>
                <a href="#clientes" class="hover:text-emerald-500 transition-colors">Experiência do Cliente</a>
            </nav>

            <div class="flex items-center gap-5">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-7 py-3 rounded-full bg-emerald-500 text-zinc-950 text-xs font-black uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-[0_0_20px_rgba(16,185,129,0.2)]">
                            Acessar Painel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest text-zinc-400 hover:text-white transition-colors">Login</a>
                        <a href="#contato" class="px-7 py-3 rounded-full border border-emerald-500/50 text-emerald-500 text-xs font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-zinc-950 transition-all">
                            Agendar Demo
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    {{-- Hero: The Value Proposition --}}
    <section class="relative pt-48 pb-24 lg:pt-64 lg:pb-40 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-10 text-center lg:text-left">
                    <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-emerald-500/5 border border-emerald-500/20 text-emerald-400 text-[11px] font-black uppercase tracking-[0.2em]">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                        Ecossistema de Saúde 4.0
                    </div>
                    
                    <h1 class="text-6xl lg:text-8xl font-extrabold leading-[0.95] tracking-tighter text-white">
                        Escalone sua <br>
                        <span class="text-emerald-500 italic">operação de saúde.</span>
                    </h1>
                    
                    <p class="text-xl text-zinc-400 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                        O ZapFlow Health OS unifica operadoras, prestadores e beneficiários em uma plataforma de alta performance. Automação completa do faturamento à validação em tempo real.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6">
                        <a href="https://wa.me/555192888828?text={{ urlencode('Olá! Vi o site e gostaria de começar a usar o ZapFlow Health OS.') }}" target="_blank" class="w-full sm:w-auto px-12 h-16 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white text-lg font-black shadow-2xl shadow-emerald-600/30 border-none flex items-center justify-center transition-all active:scale-95">
                            Começar Agora
                        </a>
                        <div class="flex items-center gap-3 group cursor-pointer">
                            <div class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center group-hover:border-emerald-500/50 transition-colors">
                                <x-icons.document-text class="w-5 h-5 text-zinc-500 group-hover:text-emerald-500" />
                            </div>
                            <span class="text-sm font-bold text-zinc-500 group-hover:text-white transition-colors uppercase tracking-widest">Ver Whitepaper</span>
                        </div>
                    </div>
                </div>

                <div class="relative group lg:scale-110">
                    <div class="absolute -inset-4 bg-emerald-500/20 rounded-[3rem] blur-[60px] opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="relative rounded-[2.5rem] overflow-hidden border border-white/5 glass-health shadow-2xl animate-float">
                        <img src="/images/hero_green.png" alt="ZapFlow Interface" class="w-full max-h-[600px] object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    
                    {{-- Metric Overlay --}}
                    <div class="absolute -bottom-8 -left-8 p-6 rounded-[2rem] bg-zinc-900 border border-emerald-500/20 shadow-3xl hidden md:block">
                        <div class="flex flex-col gap-1">
                            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Taxa de Glosa</p>
                            <h4 class="text-4xl font-black text-white">-85%</h4>
                            <p class="text-[10px] text-zinc-500 font-bold">Redução com Validação Automática</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Operators: Force for Efficiency --}}
    <section id="operadoras" class="py-32 relative border-t border-zinc-900">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16 items-end mb-24">
                <div class="flex-1 space-y-4">
                    <h2 class="text-4xl lg:text-6xl font-black text-white tracking-tight">O Motor da sua <br><span class="text-emerald-500">Operadora.</span></h2>
                </div>
                <div class="flex-1">
                    <p class="text-lg text-zinc-500 font-medium leading-relaxed">
                        Gerencie múltiplas unidades com isolamento de dados (Multi-Tenant), configure planos complexos e controle seu fluxo financeiro em um dashboard unificado projetado para escala.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-10 rounded-[2.5rem] bg-zinc-900/50 border border-zinc-800 hover:border-emerald-500/30 transition-all">
                    <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 mb-8">
                        <x-icons.building-library class="w-8 h-8" />
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Gestão Multi-Unidade</h3>
                    <p class="text-zinc-500 leading-relaxed">Arquitetura tenant robusta para segregar dados de franquias ou unidades próprias com segurança total.</p>
                </div>

                <div class="p-10 rounded-[2.5rem] bg-zinc-900/50 border border-zinc-800 hover:border-emerald-500/30 transition-all translate-y-8">
                    <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 mb-8">
                        <x-icons.banknotes class="w-8 h-8" />
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Financeiro Inteligente</h3>
                    <p class="text-zinc-500 leading-relaxed">Cobranças automáticas, controle de inadimplência e relatórios de rentabilidade por plano e especialidade.</p>
                </div>

                <div class="p-10 rounded-[2.5rem] bg-zinc-900/50 border border-zinc-800 hover:border-emerald-500/30 transition-all">
                    <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 mb-8">
                        <x-icons.chat-bubble-left-right class="w-8 h-8" />
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Engagement Hub</h3>
                    <p class="text-zinc-500 leading-relaxed">Notificações transacionais via WhatsApp integradas, reduzindo o churn e aumentando a fidelidade do cliente.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Providers: The Frictionless Portal --}}
    <section id="prestadores" class="py-32 bg-emerald-500 text-zinc-950 rounded-[4rem] mx-6">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div class="bg-white/20 p-8 rounded-[3rem] backdrop-blur-2xl border border-white/30 shadow-2xl">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between p-4 bg-zinc-950 rounded-2xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-zinc-950 font-black">JS</div>
                                    <div>
                                        <p class="text-xs font-black text-white">João Silva</p>
                                        <p class="text-[10px] text-zinc-500">Cartão Platinum</p>
                                    </div>
                                </div>
                                <x-badge color="green">Elegível</x-badge>
                            </div>
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/10 uppercase tracking-widest text-[10px] font-black">Validação em 0.4s</div>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2 space-y-8">
                    <h2 class="text-5xl lg:text-7xl font-black tracking-tighter leading-none">
                        Foco no cuidado, <br> não no papel.
                    </h2>
                    <p class="text-xl font-bold text-zinc-900/70 max-w-lg">
                        Entregue aos seus prestadores um portal clean para validação instantânea de beneficiários. Menos burocracia para eles, mais valor para sua marca.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 font-black text-xs uppercase tracking-widest">
                            <span class="w-6 h-6 rounded-full bg-zinc-950 text-emerald-500 flex items-center justify-center font-bold">✓</span>
                            Portal de validação ultra-veloz
                        </li>
                        <li class="flex items-center gap-3 font-black text-xs uppercase tracking-widest">
                            <span class="w-6 h-6 rounded-full bg-zinc-950 text-emerald-500 flex items-center justify-center font-bold">✓</span>
                            Sugestão de novas especialidades
                        </li>
                        <li class="flex items-center gap-3 font-black text-xs uppercase tracking-widest">
                            <span class="w-6 h-6 rounded-full bg-zinc-950 text-emerald-500 flex items-center justify-center font-bold">✓</span>
                            Relatórios de atendimento por período
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Beneficiaries: The Center of Everything --}}
    <section id="clientes" class="py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-3xl lg:text-5xl font-black text-white mb-6">Encante seu cliente com uma <br><span class="text-emerald-500 text-glow-emerald">jornada digital impecável.</span></h2>
                <p class="text-zinc-500 font-medium">Não entregamos apenas software, entregamos o cuidado que seu beneficiário merece através de tecnologia invisível.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-8 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-emerald-500/30 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 mb-6 group-hover:scale-110 transition-transform">
                        <x-icons.academic-cap class="w-6 h-6" />
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Cartão Digital Instantâneo</h4>
                    <p class="text-sm text-zinc-500 leading-relaxed">Seu cliente nunca esquece o cartão. Ele está sempre no celular, com QR Code para validação rápida.</p>
                </div>

                <div class="p-8 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-emerald-500/30 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 mb-6 group-hover:scale-110 transition-transform">
                        <x-icons.chat-bubble-left-right class="w-6 h-6" />
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Alertas via WhatsApp</h4>
                    <p class="text-sm text-zinc-500 leading-relaxed">Confirmações de atendimento, lembretes de exames e novidades da rede direto no app que ele já usa.</p>
                </div>

                <div class="p-8 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-emerald-500/30 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 mb-6 group-hover:scale-110 transition-transform">
                        <x-icons.list-bullet class="w-6 h-6" />
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Rede de Descontos Online</h4>
                    <p class="text-sm text-zinc-500 leading-relaxed">Acesso simples à lista de médicos e clínicas parceiras com geolocalização e tabelas de preços claras.</p>
                </div>

                <div class="p-8 rounded-3xl bg-zinc-900 border border-zinc-800 hover:border-emerald-500/30 transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 mb-6 group-hover:scale-110 transition-transform">
                        <x-icons.user-group class="w-6 h-6" />
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Autoatendimento 24h</h4>
                    <p class="text-sm text-zinc-500 leading-relaxed">Consulta de carências, histórico de atendimentos e segunda via de boletos sem precisar ligar no SAC.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Section --}}
    <section id="contato" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative rounded-[3rem] overflow-hidden bg-zinc-900 border border-zinc-800 p-12 lg:p-24 text-center">
                <div class="absolute inset-0 bg-emerald-500/5 blur-[100px] -z-10"></div>
                <div class="max-w-3xl mx-auto space-y-8">
                    <h2 class="text-4xl lg:text-6xl font-black text-white leading-tight">Pronto para transformar sua <br><span class="text-emerald-500">operação de saúde?</span></h2>
                    <p class="text-lg text-zinc-400 font-medium">Agende uma demonstração agora e veja como o ZapFlow Health OS pode escalar seu negócio.</p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-4">
                        <a href="https://wa.me/555192888828?text={{ urlencode('Olá! Gostaria de agendar uma demonstração do ZapFlow Health OS.') }}" target="_blank" class="w-full sm:w-auto px-12 py-5 rounded-2xl bg-emerald-500 text-zinc-950 text-lg font-black uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-3">
                            <x-icons.chat-bubble-left-right class="w-6 h-6" />
                            Agendar via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-20 border-t border-zinc-900 mt-20">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
            <div class="md:col-span-2 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-zinc-900 rounded-lg">
                        <x-icons.shield-check class="h-6 w-6 text-emerald-500" />
                    </div>
                    <span class="text-2xl font-black text-white tracking-tight">ZAPFLOW <span class="text-emerald-500">HEALTH</span></span>
                </div>
                <p class="max-w-xs text-sm text-zinc-500 font-medium">
                    A plataforma definitiva para modernizar sua operação de saúde e conectar-se ao futuro do cuidado digital.
                </p>
            </div>
            
            <div class="space-y-6">
                <h4 class="text-xs font-black uppercase tracking-[0.2em] text-white">Plataforma</h4>
                <nav class="flex flex-col gap-4 text-sm text-zinc-500 font-bold">
                    <a href="#" class="hover:text-emerald-500 transition-colors">Funcionalidades</a>
                    <a href="#" class="hover:text-emerald-500 transition-colors">Segurança</a>
                    <a href="#" class="hover:text-emerald-500 transition-colors">Marketplace</a>
                </nav>
            </div>

            <div class="space-y-8">
                <h4 class="text-xs font-black uppercase tracking-[0.2em] text-white">Social</h4>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full border border-zinc-800 flex items-center justify-center hover:border-emerald-500 transition-colors cursor-pointer"><x-icons.users class="w-4 h-4 text-zinc-400" /></div>
                    <div class="w-10 h-10 rounded-full border border-zinc-800 flex items-center justify-center hover:border-emerald-500 transition-colors cursor-pointer"><x-icons.building-library class="w-4 h-4 text-zinc-400" /></div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-10 border-t border-zinc-900 flex flex-col md:flex-row justify-between gap-6 text-[10px] font-black uppercase tracking-[0.3em] text-zinc-600">
            <p>© {{ date('Y') }} ZAPFLOW TECHNOLOGIES. POWERED BY LARAVEL 13.</p>
            <div class="flex gap-8">
                <a href="#" class="hover:text-white transition-colors">Privacidade</a>
                <a href="#" class="hover:text-white transition-colors">Termos</a>
                <a href="#" class="hover:text-white transition-colors">SLAs</a>
            </div>
        </div>
    </footer>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(1deg); }
        }
        .animate-float {
            animation: float 10s ease-in-out infinite;
        }
    </style>
</body>
</html>
