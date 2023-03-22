<?php

namespace Api\Payments\Domain\ValueObjects;

use Api\Shared\Domain\ValueObjects\StringValueObject;

class CheckNumber extends StringValueObject
{

    public static function random(): self
    {
        $letras = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $letra1 = $letras[rand(0, 25)];
        $letra2 = $letras[rand(0, 25)];
        $numeros = rand(100000, 999999);
        $codigo = $letra1 . $letra2 . $numeros;
        return new static($codigo);
    }
}
