<?php

namespace App\Helpers;

class TextHelper
{
    /**
     * Convert plain text to HTML with clickable links.
     * Escapes all HTML first, then converts URLs to <a> tags.
     * Also preserves newlines as <br> tags.
     */
    public static function linkify(string $text): string
    {
        // First escape all HTML entities for safety
        $escaped = e($text);

        // Convert URLs to clickable links
        $pattern = '/(https?:\/\/[^\s<]+)/i';
        $linked = preg_replace(
            $pattern,
            '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-blue-600 underline hover:text-blue-800 break-all">$1</a>',
            $escaped
        );

        // Preserve newlines
        return nl2br($linked);
    }
}
