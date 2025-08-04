<?php

if (!function_exists('clean_rupiah')) {
    function clean_rupiah($value)
    {
        if (empty($value)) return 0;
        return (int) preg_replace('/[^0-9]/', '', $value);
    }
}

// if (!function_exists('format_rupiah')) {
//     function format_rupiah($angka)
//     {
//         return number_format($angka, 0, ',', '.');
//     }
// }
