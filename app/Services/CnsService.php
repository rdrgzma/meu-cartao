<?php

namespace App\Services;

class CnsService
{
    public function validar(?string $cns): bool
    {
        if (!$cns || strlen($cns) != 15 || !ctype_digit($cns)) {
            return false;
        }

        $pis = substr($cns, 0, 11);

        if (in_array(substr($cns, 0, 1), ['1','2'])) {
            return $this->validarCnsDefinitivo($cns, $pis);
        }

        if (in_array(substr($cns, 0, 1), ['7','8','9'])) {
            return $this->validarCnsProvisorio($cns);
        }

        return false;
    }

    private function validarCnsDefinitivo($cns, $pis): bool
    {
        $soma = 0;
        $peso = 15;

        for ($i = 0; $i < 11; $i++) {
            $soma += $pis[$i] * $peso--;
        }

        $resto = $soma % 11;
        $dv = 11 - $resto;

        if ($dv == 11) $dv = 0;

        if ($dv == 10) {
            $soma += 2;
            $resto = $soma % 11;
            $dv = 11 - $resto;
            return $cns === $pis . '001' . $dv;
        }

        return $cns === $pis . '000' . $dv;
    }

    private function validarCnsProvisorio($cns): bool
    {
        $soma = 0;
        $peso = 15;

        for ($i = 0; $i < 15; $i++) {
            $soma += $cns[$i] * $peso--;
        }

        return ($soma % 11) === 0;
    }
}