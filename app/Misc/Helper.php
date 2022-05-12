<?php

namespace App\Misc;

use Illuminate\Support\Carbon;

Class Helper
{
    public static function numberFormat($number)
    {
        return number_format($number, 2, '.', '');
    }

    public static function currencyFormat($currency, $money_sign = true)
    {
        $value = str_replace('.', ',', $currency);

        return ($money_sign ? 'R$ ' : '$ ').$value;
    }

    public static function floatToPercentage($percentage)
    {
        return $percentage * 100;
    }

    public static function percentageToFloat($percentage)
    {
        return $percentage / 100;
    }

    public static function dateFormat($date)
    {
        return $date->format('d/m/Y');
    }

    public static function capitalize($string)
    {
        return ucwords(str_replace('_', ' ', $string));
    }
}
