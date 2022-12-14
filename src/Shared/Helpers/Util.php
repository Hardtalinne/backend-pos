<?php

declare(strict_types=1);

namespace App\Shared\Helpers;


abstract class Util
{
    public static function classificationIMC(float $imc): string
    {
        switch ($imc) {
            case $imc <= 18.50:
                return 'MAGREZA';
                break;
            case $imc >= 18.51 and $imc <= 24.99:
                return 'NORMAL';
                break;
            case $imc >= 25 and $imc <= 29.99:
                return 'SOBREPESO';
                break;
            case $imc >= 30 and $imc <= 39.99:
                return 'OBESIDADE';
                break;
            case $imc >= 40:
                return 'OBESIDADE GRAVE';
                break;
        }
    }
}
