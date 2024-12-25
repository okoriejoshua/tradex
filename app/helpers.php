<?php

use Carbon\Carbon;

if (! function_exists('custom_str_replace')) {
    function custom_str_replace($var, $search, $replace, $cap = 'normal')
    {
        $var = str_replace($search, $replace, $var);
        $var = preg_replace('/[^A-Za-z0-9]/', $replace, $var);

        if ($cap == 'upper') {
            $var = strtoupper($var);
        }
        if ($cap == 'lower') {
            $var = strtolower($var);
        }
        if ($cap == 'normal') {
            /** */
        }

        return $var;
    }
}

if (! function_exists('monify')) {
    function monify($amount)
    {
        return str_replace('.00', '', number_format($amount, 2, '.', ','));
    }
}

if (! function_exists('format_date')) {
    function format_date($date)
    {
        return date('d-m-Y', strtotime($date));
    }
}

if (! function_exists('day_to_future_date')) {
    function day_to_future_date($numday)
    {
        return Carbon::now()->addDays($numday)->format('d-m-Y');
        date('d-m-Y', strtotime($numday));
    }
}

if (! function_exists('unik')) {
    function unik($length = 10)
    {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return random_int($min, $max);
    }
}

if (! function_exists('first_word')) {
    function first_word($string)
    {
        $words = explode(' ', $string);
        return $words[0] ?? $string;
    }
}
