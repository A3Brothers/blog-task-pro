<?php

use \Illuminate\Support\Str;

if (!function_exists('words')) {
    /**
     * Limit the number of words in a string and strip html tags.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @param  bool  $stripHtml
     * @return string
     */
    function words(string $value, int $words = 40, string $end = '...', bool $stripHtml = false): string
    {
        if ($stripHtml) {
            return Str::words(strip_tags($value), $words, $end);
        }
        return Str::words($value, $words, $end);
    }
}
