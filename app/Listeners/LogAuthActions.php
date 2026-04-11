<?php

namespace App\Listeners;

use App\Services\LogService;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

class LogAuthActions
{
    /**
     * Handle the login event.
     */
    public function handleLogin(Login $event): void
    {
        LogService::registrar(
            'Segurança',
            'Login',
            "Usuário {$event->user->name} acessou o sistema."
        );
    }

    /**
     * Handle the logout event.
     */
    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            LogService::registrar(
                'Segurança',
                'Logout',
                "Usuário {$event->user->name} saiu do sistema."
            );
        }
    }

    /**
     * Handle the failed login event.
     */
    public function handleFailed(Failed $event): void
    {
        LogService::registrar(
            'Segurança',
            'Falha de Login',
            "Tentativa de login falhou para o e-mail: " . ($event->credentials['email'] ?? 'N/A')
        );
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleLogin',
            Logout::class => 'handleLogout',
            Failed::class => 'handleFailed',
        ];
    }
}
