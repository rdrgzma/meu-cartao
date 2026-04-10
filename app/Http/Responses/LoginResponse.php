<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = $request->user();

        $redirect = match ($user->funcao) {
            'parceiro' => route('parceiro.painel'),
            'sistema' => route('dashboard'),
            'admin' => route('dashboard'),
            default => route('dashboard'),
        };

        return redirect()->intended($redirect);
    }
}
