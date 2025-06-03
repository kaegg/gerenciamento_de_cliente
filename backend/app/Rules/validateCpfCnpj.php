<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validateCpfCnpj implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $onlyNumbers = preg_replace('/\D/', '', $value);

        if (strlen($onlyNumbers) === 11) {
            return $this->isValidCpf($onlyNumbers);
        }

        if (strlen($onlyNumbers) === 14) {
            return $this->isValidCnpj($onlyNumbers);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CPF/CNPJ informado não é válido.';
    }

    private function isValidCpf($cpf)
    {
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($i = 9; $i < 11; $i++) {
            $sum = 0;

            for ($position = 0; $position < $i; $position++) {
                $sum += $cpf[$position] * (($i + 1) - $position);
            }

            $remainder = ($sum * 10) % 11;
            $digitCheck = ($remainder === 10) ? 0 : $remainder;

            if ((int)$cpf[$i] != $digitCheck) {
                return false;
            }
        }

        return true;
    }

    private function isValidCnpj($cnpj)
    {
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $weightsFirstCheck  = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $weightsSecondCheck = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $baseCnpj = substr($cnpj, 0, 12);

        $sumFirst = 0;
        foreach ($weightsFirstCheck as $index => $weight) {
            $sumFirst += $baseCnpj[$index] * $weight;
        }

        $remainderFirst = $sumFirst % 11;
        $firstCheckDigit = ($remainderFirst < 2) ? 0 : 11 - $remainderFirst;

        $baseCnpj .= $firstCheckDigit;

        $sumSecond = 0;
        foreach ($weightsSecondCheck as $index => $weight) {
            $sumSecond += $baseCnpj[$index] * $weight;
        }

        $remainderSecond = $sumSecond % 11;
        $secondCheckDigit = ($remainderSecond < 2) ? 0 : 11 - $remainderSecond;

        return $cnpj === ($baseCnpj . $secondCheckDigit);
    }
}