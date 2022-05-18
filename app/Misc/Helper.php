<?php

namespace App\Misc;

use NumberFormatter;
use Illuminate\Support\Str;

Class Helper
{
    public static function numberFormat($number) :Float
    {
        return number_format($number, 2, '.', '');
    }

    public static function currencyFormat($amount, $currency) :String
    {
        return NumberFormatter::create('pt_BR', NumberFormatter::CURRENCY)->formatCurrency($amount, $currency);
    }

    public static function floatToPercentage($percentage) :Float
    {
        return $percentage * 100;
    }

    public static function percentageToFloat($percentage) :Float
    {
        return $percentage / 100;
    }

    public static function dateFormat($date) :String
    {
        return $date->format('d/m/Y');
    }

    public static function capitalize($string) :String
    {
        return Str::ucfirst(Str::replace('_', ' ', $string));
    }
}
