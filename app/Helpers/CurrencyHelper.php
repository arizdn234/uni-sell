<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format the given value into a more readable format with 'juta' for millions.
     *
     * @param float $amount
     * @return string
     */
    public static function formatCurrency($amount)
    {
        $formattedAmount = '';
        $amount = floatval($amount);

        if ($amount >= 1_000_000_000_000) {
            $formattedAmount = number_format($amount / 1_000_000_000_000, 2) . ' triliun';
        } elseif ($amount >= 1_000_000_000) {
            $formattedAmount = number_format($amount / 1_000_000_000, 2) . ' miliar';
        } elseif ($amount >= 1_000_000) {
            $formattedAmount = number_format($amount / 1_000_000, 2) . ' juta';
        } elseif ($amount >= 1_000) {
            $formattedAmount = number_format($amount / 1_000, 2) . ' ribu';
        } else {
            $formattedAmount = number_format($amount, 2);
        }

        return $formattedAmount;
    }
}
