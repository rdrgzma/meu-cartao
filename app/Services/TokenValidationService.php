<?php
namespace App\Services;

use App\Models\ClienteToken;

class TokenValidationService
{
    public function validar(string $token): ?ClienteToken
    {
        $registro = ClienteToken::where('token', $token)->first();

        if (!$registro || !$registro->isValido()) {
            return null;
        }

        return $registro;
    }
}