<?php

use Illuminate\Http\RedirectResponse;
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

if (!function_exists('redirectTo')) {
    /**
     * Redirect to the resource listing page with success/error message.
     *
     * @param  bool  $affectedRow
     * @param  string  $msg
     * @return RedirectResponse
     */
    function redirectTo(mixed $affectedRow, string $msg, string $route): RedirectResponse
    {
        if ($affectedRow) {
            return redirect()->route($route)->withSuccess($msg);
        }
        return redirect()->route($route)->withError('Something went wrong!');
    }
}
