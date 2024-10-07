<?php

namespace App\Helpers;

class AmountHelper
{
    public static function formatAmount(string $amount)
    {
        return 'R$ '. number_format($amount, 2, ',', '.');
    }

    public static function formatAmountToMoneyReal(string $amount)
    {
        return number_format($amount / 100, 2, ',', '.');
    }

    public static function formatForOnlyNumbers(string $value)
    {
        return preg_replace('/[^\d]+/', '', $value);
    }

    public static function calculateTax(int $amount, float $tax)
    {
        return $amount * $tax;
    }
}
