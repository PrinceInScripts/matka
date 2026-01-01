<?php

namespace App\Constants;

class GameTypes
{
    public const SINGLE_DIGIT = 1;
    public const JODI_DIGIT   = 2;

    public const SINGLE_PANNA = 9;
    public const DOUBLE_PANNA = 10;
    public const TRIPLE_PANNA = 11;

    public const HALF_SANGAM  = 12;
    public const FULL_SANGAM  = 13;

    public const PANNA_TYPES = [
        self::SINGLE_PANNA,
        self::DOUBLE_PANNA,
        self::TRIPLE_PANNA,
    ];
}
