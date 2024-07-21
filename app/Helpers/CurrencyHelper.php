<?php

if (! function_exists('currency')) {
    function currency($value)
    {
        // Replace this logic with your desired currency formatting
        return '€' . number_format($value, 2);
    }
}
