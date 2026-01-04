<?php

namespace App\Services;

use App\Constants\GameTypes;
use Exception;

class AnkCalculator
{
    public static function calculate(string $gameTypeSlug, string $number, string $session): int
    {
        
        // 1️⃣ Single Digit
        if ($gameTypeSlug === 'single_digit' || $gameTypeSlug === 'single_digit_bulk') {
            return (int) $number;
        }

        // 2️⃣ Jodi Digit
        if ($gameTypeSlug === 'jodi' || $gameTypeSlug === 'jodi_bulk') {
            if (strlen($number) !== 2 || !ctype_digit($number)) {
                throw new Exception("Invalid jodi number: $number");
            }

            return $session === 'open'
                ? (int) $number[0]
                : (int) $number[1];
        }

        // 3️⃣ Panna (single / double / triple)
        if (in_array($gameTypeSlug, ['single_panna', 'double_panna', 'triple_panna', 'single_panna_bulk', 'double_panna_bulk', 'triple_panna_bulk'], true)) {
            if (!ctype_digit($number)) {
                throw new Exception("Invalid panna number: $number");
            }

            return array_sum(str_split($number)) % 10;
        }

        // 4️⃣ Half Sangam (panna-digit OR digit-panna)
        if ($gameTypeSlug === 'half_sangam') {
            if (!str_contains($number, '-')) {
                throw new Exception("Invalid half sangam: $number");
            }

            [$left, $right] = explode('-', $number);

            $target = $session === 'open' ? $left : $right;

            return ctype_digit($target)
                ? array_sum(str_split($target)) % 10
                : (int) $target;
        }

        // 5️⃣ Full Sangam (panna-panna)
        if ($gameTypeSlug === 'full_sangam') {
            if (!str_contains($number, '-')) {
                throw new Exception("Invalid full sangam: $number");
            }

            [$openPanna, $closePanna] = explode('-', $number);

            $target = $session === 'open' ? $openPanna : $closePanna;

            if (!ctype_digit($target)) {
                throw new Exception("Invalid sangam panna: $number");
            }

            return array_sum(str_split($target)) % 10;
        }

        throw new Exception("Unsupported game type ID: $gameTypeSlug");
    }
}
