<?php

namespace App\Services;

class GameNumberService
{
    /**
     * Return all valid combinations for a given game code.
     */
    public static function getCombinations(string $gameCode): array
    {
        return match ($gameCode) {
            'single_digit'  => collect(range(0, 9))
                                ->map(fn($i) => (string)$i)
                                ->toArray(),

            'jodi'          => collect(range(0, 99))
                                ->map(fn($i) => str_pad($i, 2, '0', STR_PAD_LEFT))
                                ->toArray(),

            'single_panna'  => self::generateSinglePanna(),
            'double_panna'  => self::generateDoublePanna(),
            'triple_panna'  => self::generateTriplePanna(),
            'single_digit_bulk' => collect(range(0, 9))
                                ->map(fn($i) => (string)$i)
                                ->toArray(),
             'jodi_bulk'          => collect(range(0, 99))
                                ->map(fn($i) => str_pad($i, 2, '0', STR_PAD_LEFT))
                                ->toArray(),
              'single_panna_bulk'  => self::generateSinglePanna(),
            'double_panna_bulk'  => self::generateDoublePanna(),
            'triple_panna_bulk'  => self::generateTriplePanna(),

            default         => [],
        };
    }

    /**
     * Generate all valid single panna numbers (120 sets).
     * All digits are unique, order doesn’t matter.
     */
    protected static function generateSinglePanna(): array
    {
        $result = [];

        for ($i = 0; $i <= 9; $i++) {
            for ($j = 0; $j <= 9; $j++) {
                for ($k = 0; $k <= 9; $k++) {
                    if ($i !== $j && $i !== $k && $j !== $k) {
                        $result[] = "{$i}{$j}{$k}";
                    }
                }
            }
        }

        // collapse permutations into 120 unique sets
        return collect($result)
            ->unique(fn($num) => collect(str_split($num))->sort()->implode(''))
            ->values()
            ->toArray();
    }

    /**
     * Generate double panna numbers (90 sets).
     * Two same digits + one different digit.
     */
    protected static function generateDoublePanna(): array
    {
        $result = [];

        for ($i = 0; $i <= 9; $i++) {
            for ($j = 0; $j <= 9; $j++) {
                if ($i !== $j) {
                    $result[] = "{$i}{$i}{$j}";
                }
            }
        }

        return $result;
    }

    /**
     * Generate triple panna numbers (10 sets).
     * All three digits identical.
     */
    protected static function generateTriplePanna(): array
    {
        $result = [];

        for ($i = 0; $i <= 9; $i++) {
            $result[] = "{$i}{$i}{$i}";
        }

        return $result;
    }
}
